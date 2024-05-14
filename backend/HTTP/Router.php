<?php

namespace Backend\Http;

use Exception;

class Router
{

  public function match(string $url): array
  {
    try {
      return $this->routes()[$url];
    } catch (\Throwable $th) {
      throw new Exception("Not Found", 404);
    }
  }

  public function getAllRoutes(): array
  {
    return $this->routes();
  }

  protected function routes(): array
  {
    return [
      '/' => ['GET' => 'Backend\\Http\\ProductController@index'],
      '/create' => ['GET' => 'Backend\\Http\\ProductController@create'],
      '/store' => ['POST' => 'Backend\\Http\\ProductController@store'],
      '/delete' => ['DELETE' => 'Backend\\Http\\ProductController@delete'],
    ];
  }
}
