<?php
class Form_Register extends Form_Base
{
    function __construct()
    {
        $this->templateFile = "Form/Register";
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
        } else {
            // Check email valid
            if (!filter_var($this->formValue['email'], FILTER_VALIDATE_EMAIL)) {
                $this->addError("Email field is not valid");
            }
        }
        if (empty($this->formValue['name'])) {
            $this->addError("Name field can not be empty");
        }
        if (empty($this->formValue['pass'])) {
            $this->addError("Password field can not be empty");
        }
        if (empty($this->formValue['passconfirm'])) {
            $this->addError("Confirm Password field can not be empty");
        }

        // Check existing user name and email
        $userObj = new User();
        if ($userObj->existsName($this->formValue['name'])) {
            $this->addError("Provided name is already taken.");
        }
        if ($userObj->existsEmail($this->formValue['email'])) {
            $this->addError("Provided email is already taken.");
        }

        // Check password matching
        if ($this->formValue['pass'] != $this->formValue['passconfirm']) {
            $this->addError("Password does not match the confirm password.");
        }
    }

    /**
     * Form submit process
     * @return void
     */
    protected function submit()
    {
        $userObj = new User();
        $userObj->setName($this->formValue['name']);
        $userObj->setPassAndHash($this->formValue['pass']);
        $userObj->setEmail($this->formValue['email']);
        $userObj->insert();

        $this->addNotice("User \"" . $this->formValue['name'] . "\" is saved.");
    }
}