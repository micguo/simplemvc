<?php
define('ROOTDIR', realpath(__DIR__ . '/../'));
define('TEMPLATEDIR', ROOTDIR . "/Template/");
define('AUTOLOADER', ROOTDIR . '/vendor/autoload.php');

if (!file_exists(AUTOLOADER)) {
    throw new Exception("Please do 'composer install'");
}

require_once(AUTOLOADER);

$routeArray = explode("/", $_SERVER['REQUEST_URI']);
try {
    switch (count($routeArray)) {
        case 2:
            if (empty($routeArray[1])) {
                $controllerName = "HomeController";
            } else {
                $controllerName = ucfirst(strtolower($routeArray[1])) . "Controller";
            }
            $actionName = "indexAction";
            break;
        case 3:
            $controllerName = ucfirst(strtolower($routeArray[1])) . "Controller";
            $actionName = $routeArray[2] . "Action";
            break;
        default:
            throw new Exception("Requested url does not exist.");
            break;
    }

    // Check whether Controller exists
    if (!class_exists($controllerName)) {
        throw new Exception("Requested url does not exist.");
    }
    // Check whether Action exists 
    if (!method_exists($controllerName, $actionName)) {
        throw new Exception("Requested url does not exist.");
    }
    
    $controllerObj = new $controllerName();
    // Call page action
    $controllerObj->$actionName();
} catch (Exception $e) {
    echo "<pre>";
    echo $e;
    echo "</pre>";
}