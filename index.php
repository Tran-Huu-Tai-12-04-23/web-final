<?php
    ob_start();
    require_once 'config/config.php';
    define('BASE_URL_IMG', 'http://localhost/');
    header('Access-Control-Allow-Origin: *');

    include './config/index.php';
    include './config/language.php';
    include './api/App.php';
    include './routes/index.php';
    include './utils/index.php';
    include './middleware/index.php';
    $App = new App();
    // handle get request change route of application
    $url = isset($_GET['url']) ? $_GET['url'] : '' ;
    if(  substr($url, strlen($url)-1) === '/' ) {
        $url = substr($url,0, strlen($url)-1);
    }
    if (array_key_exists($url, $routes)) {
        $Route = $routes[$url]();
        $App->setView($Route->getView());
        $App->setModel($Route->getModel());
        $App->run();
    } else {
        $url = 'not-found';
        $Route = $routes[$url]();
        $App->setView($Route->getView());
        $App->setModel($Route->getModel());
        $App->run();
    }
    // array_push($prevUrl,$_SERVER['HTTP_REFERER']);
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $data = isset($_GET['data']) ? $_GET['data'] : '';
    $App->action($action, $data, '');
    // view => file upload.php
    // model => file ''
    // /login /home/ upload / ainmput 
?>