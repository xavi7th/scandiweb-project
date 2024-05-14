<?php

namespace Backend\Http;

use Backend\Http\Request;


class Response
{
  /**
   * Status codes translation table.
   *
   * The list of codes is complete according to the
   * {@link https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml Hypertext Transfer Protocol (HTTP) Status Code Registry}
   * (last updated 2021-10-01).
   *
   * Unless otherwise noted, the status code is defined in RFC2616.
   *
   * @var array
   */
  public static $statusTexts = [
    100 => 'Continue',
    101 => 'Switching Protocols',
    102 => 'Processing',            // RFC2518
    103 => 'Early Hints',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    207 => 'Multi-Status',          // RFC4918
    208 => 'Already Reported',      // RFC5842
    226 => 'IM Used',               // RFC3229
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    308 => 'Permanent Redirect',    // RFC7238
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Content Too Large',                                           // RFC-ietf-httpbis-semantics
    414 => 'URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Range Not Satisfiable',
    417 => 'Expectation Failed',
    418 => 'I\'m a teapot',                                               // RFC2324
    421 => 'Misdirected Request',                                         // RFC7540
    422 => 'Unprocessable Content',                                       // RFC-ietf-httpbis-semantics
    423 => 'Locked',                                                      // RFC4918
    424 => 'Failed Dependency',                                           // RFC4918
    425 => 'Too Early',                                                   // RFC-ietf-httpbis-replay-04
    426 => 'Upgrade Required',                                            // RFC2817
    428 => 'Precondition Required',                                       // RFC6585
    429 => 'Too Many Requests',                                           // RFC6585
    431 => 'Request Header Fields Too Large',                             // RFC6585
    451 => 'Unavailable For Legal Reasons',                               // RFC7725
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    506 => 'Variant Also Negotiates',                                     // RFC2295
    507 => 'Insufficient Storage',                                        // RFC4918
    508 => 'Loop Detected',                                               // RFC5842
    510 => 'Not Extended',                                                // RFC2774
    511 => 'Network Authentication Required',
    512 => 'Already Exist',                             // RFC6585
  ];

  public $statusCode;
  public $statusText;
  public $headers;
  public $content;
  public $protocolVersion;

  public function __construct(?string $content = '', int $status = 200, array $headers = [], string $protocolVersion = '')
  {
    $this->protocolVersion = $protocolVersion;
    $this->setHeaders($headers);
    $this->setContent($content);
    $this->setStatusCode($status);
  }

  /**
   * Sets the response headers.
   *
   * @return $this
   */
  public function setHeaders(?array $headers)
  {
    foreach ($headers as $key => $value) {
      $this->headers[$key] = $value;
    }

    // Fix possible malformed Content-Type
    if (!isset($this->headers['Content-Type'])) {
      $this->headers['Content-Type'] = 'text/html; charset=UTF-8';
    } elseif (0 === stripos($this->headers['Content-Type'], 'text/') && false === stripos($this->headers['Content-Type'], 'charset')) {
      // add the charset
      $this->headers['Content-Type'] = $this->headers['Content-Type'] . '; charset=UTF-8';
    }

    //Set cache control
    $this->headers['Cache-Control'] = '';
    $this->headers['Date'] = gmdate('D, d M Y H:i:s') . ' GMT';

    return $this;
  }

  /**
   * Sets the response content.
   *
   * @return $this
   */
  public function setContent(?string $content)
  {
    $this->content = $content ?? '';

    return $this;
  }

  /**
   * Sets the response status code.
   *
   * If the status text is null it will be automatically populated for the known
   * status codes and left empty otherwise.
   *
   * @return $this
   *
   * @throws \InvalidArgumentException When the HTTP status code is not valid
   */
  public function setStatusCode(int $code, string $text = null): object
  {
    if ($code < 100 || $code >= 600) {
      throw new \InvalidArgumentException(sprintf('The HTTP status code "%s" is not valid.', $code));
    }

    $this->statusCode = $code;

    if (null === $text) {
      $this->statusText = self::$statusTexts[$code] ?? 'Unknown Status';

      return $this;
    }

    if (false === $text) {
      $this->statusText = '';

      return $this;
    }

    $this->statusText = $text;

    return $this;
  }

  /**
   * Sends HTTP headers.
   *
   * @return $this
   */
  public function sendHeaders()
  {
    // headers have already been sent
    if (headers_sent()) {
      return $this;
    }

    // headers
    foreach ($this->headers as $name => $value) {

      // Add more Content-Type headers if exists
      $replace = 0 === strcasecmp($name, 'content-type');

      header($name . ': ' . $value, $replace, $this->statusCode);
    }

    // Protocol
    header(sprintf('HTTP/%s %s %s', $this->protocolVersion, $this->statusCode, $this->statusText), true, $this->statusCode);

    return $this;
  }

  /**
   * Sends content for the current web response.
   *
   * @return $this
   */
  public function sendContent()
  {
    echo $this->content;

    return $this;
  }

  /**
   * Sends HTTP headers and content.
   *
   * @return $this
   */
  public function send()
  {
    $this->sendHeaders();
    $this->sendContent();

    if (\function_exists('fastcgi_finish_request')) {
      fastcgi_finish_request();
    } elseif (\function_exists('litespeed_finish_request')) {
      litespeed_finish_request();
    } elseif (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true)) {
      static::closeOutputBuffers(0, true);
      flush();
    }

    return $this;
  }

  /**
   * Returns the Response as an HTTP string.
   *
   * The string representation of the Response is the same as the
   * one that will be sent to the client only if the prepare() method
   * has been called before.
   *
   * @return string
   *
   * @see prepare()
   */
  public function __toString()
  {

    return
      sprintf('HTTP/%s %s %s', $this->protocolVersion, $this->statusCode, $this->statusText) . "\r\n" .
      $this->headers . "\r\n" .
      $this->content;
  }

  /**
   * Cleans or flushes output buffers up to target level.
   *
   * Resulting level can be greater than target level if a non-removable buffer has been encountered.
   *
   * @final
   */
  public static function closeOutputBuffers(int $targetLevel, bool $flush): void
  {
    $status = ob_get_status(true);
    $level = \count($status);
    $flags = \PHP_OUTPUT_HANDLER_REMOVABLE | ($flush ? \PHP_OUTPUT_HANDLER_FLUSHABLE : \PHP_OUTPUT_HANDLER_CLEANABLE);

    while ($level-- > $targetLevel && ($s = $status[$level]) && (!isset($s['del']) ? !isset($s['flags']) || ($s['flags'] & $flags) === $flags : $s['del'])) {
      if ($flush) {
        ob_end_flush();
      } else {
        ob_end_clean();
      }
    }
  }
}
