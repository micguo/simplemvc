<?php
class HomeController
{
    function indexAction()
    {
        $template = new Template("Home/Index");
        $searchForm = new Form_Search();
        $data = array(
            'Form' => $searchForm->getForm()
        );
        $template->render($data);
    }
}