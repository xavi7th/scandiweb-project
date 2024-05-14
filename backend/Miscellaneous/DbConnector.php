<?php

namespace Backend\Miscellaneous;

use Backend\Logger\Log;

class DbConnector
{
  const SERVER_NAME = 'localhost';
  const USER_NAME = 'root';
  const PASSWORD = '';
  const DB = 'test';

  private $connector;
  public $err_logs;

  public function __construct()
  {
    $this->err_logs = new Log();

    $this->connector = new \mysqli(static::SERVER_NAME, static::USER_NAME, static::PASSWORD, static::DB);
    if ($this->connector->connect_error) {
      die('DB Connect Error (' . $this->connector->connect_errno . ') ' . $this->connector->connect_error);
    }
  }

  public function getConnection(): \mysqli
  {
    return $this->connector;
  }

  public function getError(): string
  {
    return $this->connector->error;
  }

  public function sqlQuery($query)
  {
    $result = $this->connector->query($query);

    return $result;
  }

  public function is_connected(): bool
  {
    return $this->connector === false;
  }
}
