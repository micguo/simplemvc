<?php
class LogoutController
{
    function indexAction()
    {
        User::logout();
        header("Location: http://{$_SERVER['SERVER_NAME']}/");
    }
}