<?php
class LoginController
{
    function indexAction()
    {
        $template = new Template("Login/Index");
        $form = new FormLogin();
        $form->handleSubmit();
        
        if (User::isLogin()) {
            $data = array('Form' => "Welcome, " . User::getActiveUser()->getName() . "! (<a href='/logout'>Logout</a>)");
        } else {
            $data = array('Form' => $form->getForm());
        }
        
        $template->render($data);
    }
}