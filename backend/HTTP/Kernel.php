<?php

namespace Backend\Http;

use Backend\Logger\Log;
use Backend\Http\Router;
use Backend\Http\Request;

class Kernel
{
  private $router;
  private $request;
  private $logger;
  private $protocolVersion;

  public function __construct(Request $request, Router $router)
  {
    $this->request = $request;
    $this->router = $router;
    $this->protocolVersion = $request->getProtocolVersion();
    $this->logger = new Log;
  }

  public function findRoute(string $url): array
  {
    try {
      return $this->router->match($url);
    } catch (\Throwable $th) {
      return [];
    }
  }

  public function runRouteHandler(array $routeInfo)
  {
    // If no matched route return 404 page
    if (empty($routeInfo))  return (new ErrorResponse(404, 'PAGE NOT FOUND'))->html();

    $matchedRoute = $routeInfo[$this->request->method()];

    // Check if this request method matches any route definition
    if (!$matchedRoute)  return (new ErrorResponse(405, 'METHOD NOT ALLOWED'))->html();

    list($controllerClass, $action) = explode('@', $matchedRoute);

    if (!$controllerClass || !$action) return (new ErrorResponse(500, 'MALFORMED ROUTE'))->html();

    //Initialise the controller
    try {
      $controller = (new $controllerClass());
    } catch (\Throwable $th) {
      error_log($th->getMessage());
      return (new ErrorResponse(500, 'INVALID ROUTE CONTROLLER:  <i>' . array_pop(explode('\\', $controllerClass)) . '</i>'))->html();
    }

    try {
      $viewResponse = (new $controller())->$action();
    }
    catch (\PDOException $th) {
      error_log($th->getMessage());
      $this->logger->addError('A DATABASE ERROR OCCURED');

      return new Response('', 302, ['Content-Type' => 'text/html', 'Location' => '/'], $this->protocolVersion);
    }
    catch (\Throwable $th) {
      error_log($th->getMessage());
      return (new ErrorResponse(500, 'CONTROLLER METHOD <i>'. $action . '</i>() DOES NOT EXIST' ))->html();
    }

    // A GET request MUST return valid html to return to the browser
    if (!is_string($viewResponse) && $this->request->isMethod('GET')) return (new ErrorResponse(500, 'INVALID RESPONSE'))->html();

    return $this->request->isMethod('GET')
        ? new Response($viewResponse, 200, ['Content-Type' => 'text/html'], $this->protocolVersion)
        : new Response('', 302, ['Content-Type' => 'text/html', 'Location' => '/'], $this->request->getProtocolVersion());
  }

  public function handle()
  {
    $routeInfo = $this->findRoute($this->request->uri());

    $response = $this->runRouteHandler($routeInfo);

    return $response;
  }
}
