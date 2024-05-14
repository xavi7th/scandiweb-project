<?php

use Backend\Autoloader;

include './Autoloader.php';
$app = new Autoloader();

$app->setPrefix('./');
$app->register();

$controller = new Controller();

if ($_REQUEST['_method'] == 'post') {
  switch ($app->request->method()) {
    case 'POST':
      $controller->processSaveProductRequest($app->request);
      break;
  }
}

if ($_REQUEST['_method'] == 'delete') {
  switch ($app->request->method()) {
    case 'DELETE':
      $controller->processDeleteProductsRequest($app->request);
      break;
  }
}

// Fall back route. Redirect all stray requests to the home page. Optionally throw a 404 error here
$app->request->redirect_to_route('../');