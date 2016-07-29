<?php
abstract class Form_Base
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
            'noticeMessage' => $noticeMessage
        );
        foreach ($this->formValue as $key => $value) {
            $data[$key] = $value;
        } 
        return $template->render(
            $data,
            true
        );
    }

    public function handleSubmit()
    {
        if (!empty($_POST)) {
            $this->formValue = $_POST;
            $this->validate();
            if (!$this->hasError()) {
                $this->submit();
            }
        }
    }

    protected function addError($errorString)
    {
        $this->errorMessageArray[] = $errorString;
    }

    protected function addNotice($noticeString)
    {
        $this->noticeMessageArray[] = $noticeString;
    }

    /**
     * [hasError description]
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