<?php
class LoginController
{
    function indexAction()
    {
        $template = new Template("Login/Index");
        $form = new Form_Login();

        $form->handleSubmit();

        $data = array(
            'Form' => $form->getForm()
        );
        $template->render($data);
    }
}