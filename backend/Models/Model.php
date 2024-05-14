<?php

namespace Backend\Models;

use Backend\Miscellaneous\DbConnector;


class Model extends DbConnector
{
  protected $connection;

  public function __construct()
  {
    parent::__construct();
    $this->connection = $this->getConnection();
  }

  public function toObject($array)
  {
    return is_array($array) && !empty($array) ? (object) array_map([__CLASS__, __METHOD__], $array) : (gettype($array) == 'object' && empty((array)$array) ? null : $array);
  }

  static function query()
  {
    return new static;
  }
}
