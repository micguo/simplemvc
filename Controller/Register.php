<?php
class RegisterController
{
    function indexAction()
    {
        $template = new Template("Register/Index");
        $form = new FormRegister();
        
        $form->handleSubmit();

        $data = array(
            'Form' => $form->getForm()
        );
        $template->render($data);
    }
}