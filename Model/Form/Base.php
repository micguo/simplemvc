<?php
/**
 * Base class for all other form class
 */
abstract class FormBase
{
    private $errorMessageArray = array();
    private $noticeMessageArray = array();
    protected $templateFile = null;
    protected $formValue = array();

    public function getForm()
    {
        $template = new Template($this->templateFile);
        
        $errorMessage = "";
        foreach ($this->errorMessageArray as $value) {
            $errorMessage .= "<li>" . $value . "</li>";
        }

        $noticeMessage = "";
        foreach ($this->noticeMessageArray as $value) {
            $noticeMessage .= "<li>" . $value . "</li>";
        }
        
        $data = array(
            'errorMessage' => $errorMessage,
            'noticeMessage' => $noticeMessage,
        );
        foreach ($this->formValue as $key => $value) {
            $data[$key] = $value;
        } 
        return $template->render(
            $data,
            true
        );
    }

    /**
     * Main function for form submission handling
     * @return void
     */
    public function handleSubmit()
    {
        if (!empty($_POST)) {
            $this->formValue = $_POST;
            $this->validate();

            // If no error, go to next step
            if (!$this->hasError()) {
                $this->submit();
            }
        }
    }

    /**
     * Add an error message
     * @param String $errorString [description]
     */
    public function addError($errorString)
    {
        $this->errorMessageArray[] = $errorString;
    }

    /**
     * Add a notice message
     * @param String $noticeString [description]
     */
    public function addNotice($noticeString)
    {
        $this->noticeMessageArray[] = $noticeString;
    }

    /**
     * Check whether we have any error
     * @return boolean
     */
    private function hasError()
    {
        $returnVal = false;
        if (!empty($this->errorMessageArray)) {
            $returnVal = true;
        }

        return $returnVal;
    }

    protected abstract function validate();
    protected abstract function submit();
}