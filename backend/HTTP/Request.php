<?php

namespace Backend\Http;

use Backend\Logger\Log;

class Request
{

  public $notifications;
  public $params;

  public function __construct()
  {
    $this->notifications = new Log();
  }

  /**
   * Get the HTTP method of the current request
   */
  public function method(): string
  {
    return isset($_REQUEST['_method']) ? strtoupper($_REQUEST['_method']) : $_SERVER['REQUEST_METHOD'];
  }

  public function isMethod(string $method): bool
  {
    return strtoupper($method) === $this->method();
  }

  public function all()
  {
    return array_diff_key($_REQUEST, array('_method' => 0));;
  }

  public function uri()
  {
    return str_ireplace(['.php', $_SERVER['HTTP_HOST'], 'http://', 'https://'], '', $_SERVER['REQUEST_URI']);
  }

  public function redirect_to_route($route)
  {
    header("Location: " . $route);
  }

  public function server($key = null)
  {
    return is_null($key) ? (object) $_SERVER : $_SERVER[$key];
  }

  public function view(string $path, array $params = null): string
  {
    $res = ob_start();

    $this->params = (object) $params;

    include './backend/Views/' . $path;

    $value = ob_get_contents();
    ob_end_clean();

    return $value;
  }

  public function getProtocolVersion(): string
  {
    return 'HTTP/1.0' != $this->server()->SERVER_PROTOCOL ? '1.0' : '1.1';
  }

  public function __call($method, $param)
  {
    exit($method);
    return $_REQUEST[''];
  }

  public function __get($key)
  {
    if (array_key_exists($key, $this->all())) {
      return $_REQUEST[$key];
    } else {
      return NULL;
    }
  }
}
