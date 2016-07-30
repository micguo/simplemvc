<?php
class HomeController
{
    function indexAction()
    {
        $template = new Template("Home/Index");
        $searchForm = new FormSearch();
        $data = array(
            'Form' => $searchForm->getForm()
        );
        $template->render($data);
    }
}