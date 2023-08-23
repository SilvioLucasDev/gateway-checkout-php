<?php
  class Response {
    private string $httpCode;
    private $content;
    private array $headers;

    public function __construct(string $httpCode = '200', $content) {
      $this->httpCode = $httpCode;
      $this->content = $content;
      $this->addHeader('Content-Type', 'application/json');
      $this->addHeader('Access-Control-Allow-Origin', '*');
    }

    public function addHeader(string $key, string $value): void {
      $this->headers[$key] = $value;
    }

    private function setHeaders(): void {
      http_response_code($this->httpCode);
      foreach ($this->headers as $key => $value) {
        header("$key: $value");
      }
    }

    public function sendResponse(): void {
      $this->setHeaders();
      echo json_encode(['data' => $this->content]);
    }
  }
?>
