<?php

namespace App\http\config;

class Response
{
  private string $httpCode;
  private mixed $content;
  private array $headers;

  public function __construct(mixed $content, string $httpCode = '200')
  {
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->addHeader('Content-Type', 'application/json');
    $this->addHeader('Access-Control-Allow-Origin', '*');
  }

  public function addHeader(string $key, string $value): void
  {
    $this->headers[$key] = $value;
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
    $isError = $this->httpCode !== '200' && $this->httpCode !== '204' ? true : false;
    echo json_encode(
      [$isError ? 'error' : 'data' => $this->content]
    );
  }
}
