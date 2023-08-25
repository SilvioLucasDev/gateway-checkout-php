<?php

namespace App\Http\Config;

class Response
{
  private int   $httpCode;
  private mixed $content;
  private array $headers;

  public function __construct(mixed $content, int $httpCode = 200)
  {
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->headers['Content-Type'] = 'application/json';
    $this->headers['Access-Control-Allow-Origin'] = '*';
  }

  private function setHeaders(): void
  {
    http_response_code($this->httpCode);
    foreach ($this->headers as $key => $value) {
      header("$key: $value");
    }
  }

  public function sendResponse(): void
  {
    $this->setHeaders();
    $isError = ($this->httpCode !== 200 && $this->httpCode !== 204);
    echo json_encode([$isError ? 'error' : 'data' => $this->content]);
  }
}
