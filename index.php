<?php
require_once 'bootstrap.php';


use app\Controllers\MainController;
use app\Controllers\UserController;

$router = new League\Route\Router;

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

session_start();

// map a route
$router->map('GET','/', function () {
    return (new MainController())->index();
});
$router->map('GET','/add-post/', function () {
    return (new MainController())->addPost();
});
$router->map('GET','/edit-post/', function () {
    return (new MainController())->editPost();
});
$router->map('POST','/save/', function () {
    return (new MainController())->save();
});
$router->map('GET','/user/login/', function () {
    return (new UserController())->login();
});
$router->map('POST','/user/login/', function () {
    return (new UserController())->login();
});

$response = $router->dispatch($request);


// send the response to the browser
(new Zend\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);