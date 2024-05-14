<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set("log_errors", 1);
ini_set("error_log", "./errors.log");

include './backend/Autoloader.php';

use Backend\Autoloader;
use Backend\Http\Kernel;
use Backend\Http\Router;
use Backend\Http\Request;

$app = new Autoloader();
$app->register();

$request = new Request;
$router = new Router;

$app = new Kernel($request, $router);

$response = $app->handle();

$response->send();
