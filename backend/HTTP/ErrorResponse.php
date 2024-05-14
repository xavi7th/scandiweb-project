<?php

namespace Backend\Http;

use Backend\Http\Request;
use Backend\Http\Response;

class ErrorResponse
{
  private $request;
  private $errorCode;
  private $errorMsg;

  public function __construct(int $errorCode, string $errorMsg)
  {
    $this->request = new Request;
    $this->errorCode = $errorCode;
    $this->errorMsg = $errorMsg;
  }

  public function html()
  {
    return new Response($this->request->view('error.php', ['errorCode' => $this->errorCode, 'errorMsg' => $this->errorMsg]), $this->errorCode, ['Content-Type' => 'text/html'], $this->request->getProtocolVersion());
  }
}
