<?php
class ResultController
{
    function indexAction()
    {
        $template = new Template("Result/Index");

        if (!User::isLogin()) {
            // If user isn't logged in
            $form = new FormLogin();
            $form->addError('Please log in');
        } else {
            $form = new FormSearch();
            $form->handleSubmit();
        }
        $data = array(
            'Form' => $form->getForm()
        );
        $template->render($data);
    }
}