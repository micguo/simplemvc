<?php
class Form_Login extends Form_Base
{
    function __construct()
    {
        $this->templateFile = "Form/Login";
    }

    /**
     * Form validate process
     * @return void
     */
    protected function validate()
    {
        // Check fields are not empty
        if (empty($this->formValue['email'])) {
            $this->addError("Email field can not be empty");
        }
        if (empty($this->formValue['pass'])) {
            $this->addError("Password field can not be empty");
        }

        $userObj = new User();
        $data = array(
            'Email' => $this->formValue['email'],
            'Pass' => $this->formValue['pass']
        );

        if (!$userObj->load($data)) {
            $this->addError("Username and password dosen't match.");
        } else {
            $_SESSION['uid'] = $userObj->getId();
        }
    }

    /**
     * Form submit process
     * @return void
     */
    protected function submit()
    {
        // Log user in!
        global $activeUser;
        $activeUser = new User();
        $activeUser->load($_SESSION['uid']);
    }
}