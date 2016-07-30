<?php
class LoginController
{
    function indexAction()
    {
        $template = new Template("Login/Index");
        $form = new Form_Login();
        $form->handleSubmit();
        
        if (!empty($GLOBALS['activeUser'])) {
            $data = array('Form' => "Welcome, " . $GLOBALS['activeUser']->getName() . "! (<a href='/logout'>Logout</a>)");
        } else {
            $data = array('Form' => $form->getForm());
        }
        
        $template->render($data);
    }
}