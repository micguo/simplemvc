<?php
class LogoutController
{
    function indexAction()
    {
        unset($GLOBALS['activeUser']);
        unset($_SESSION['uid']);
        header("Location: http://{$_SERVER['SERVER_NAME']}/");
    }
}