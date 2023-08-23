<?php
  class Request {
    private Router $router;
    private string $httpMethod;
    private string $uri;
    private array  $queryParams;
    private array  $postVars;
    private array  $headers;

    public function __construct(Router $router) {
      $this->router = $router;
      $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
      $this->queryParams = $_GET ?? [];
      $this->postVars = $_POST ?? [];
      $this->headers = getallheaders();
      $this->setUri();
    }

    private function setUri(){
      $this->uri = $_SERVER['REQUEST_URI'] ?? '';
      $xUri = explode('?', $this->uri);
      $this->uri = $xUri[0];
    }

    public function getRouter(): Router {
      return $this->router;
    }

    public function getHttpMethod(): string {
      return $this->httpMethod;
    }

    public function getUri(): string {
      return $this->uri;
    }

    public function getQueryParams(): array {
      return $this->queryParams;
    }

    public function getPostVars(): array {
      return $this->postVars;
    }

    public function getHeaders(): array {
      return $this->headers;
    }
  }
?>
