<?php
class ResultController
{
    function indexAction()
    {
        $template = new Template("Result/Index");

        if (empty($GLOBALS['activeUser'])) {
            // If user isn't logged in
            $form = new Form_Login();
            $form->addError('Please log in');
        } else {
            $form = new Form_Search();
            $form->handleSubmit();
        }
        $data = array(
            'Form' => $form->getForm()
        );
        $template->render($data);
    }
}