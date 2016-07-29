<?php
class Template
{
    private $templateFileLocation = null;
    /**
     * Constructor
     * 
     * @param String $templateFile
     */
    function __construct($templateFile)
    {
        if (!is_string($templateFile)) {
            throw new InvalidArgumentException();
            
        }
        $this->templateFileLocation = TEMPLATEDIR . $templateFile . ".phtml";
    }

    /**
     * Render template html
     * 
     * @param array $data
     * @param boolean, parameter to control whether print on screen or return render result
     * 
     * @return mixed, string when $hasReturnVal is true
     *                void when $hasReturnVal is false
     */
    public function render($data = array(), $hasReturnVal = false)
    {
        if (!is_array($data) || !is_bool($hasReturnVal)) {
            throw new InvalidArgumentException();
        }

        $returnVal = file_get_contents($this->templateFileLocation);
        // replace tokens
        foreach ($data as $key => $value) {
            $returnVal = preg_replace("/{{\s*?" . $key ."\s*?}}/", $value, $returnVal);
        }

        // remove tokens are not replaced
        $returnVal = preg_replace("/{{.*?}}/", $value, $returnVal);

        if ($hasReturnVal == true) {
            return $returnVal;
        } else {
            echo $returnVal;
        }
    }
}