<?php

namespace App\Http\Config;

class Request
{
  private Router $router;
  private string $httpMethod;
  private string $uri;
  private array  $queryParams;
  private array  $postVars;
  private array  $headers;

  public function __construct(Router $router)
  {
    $this->router = $router;
    $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->headers = getallheaders();
    $this->setUri();
    $this->setPostVars();
    $this->setQueryParams();
  }

  private function setUri(): void
  {
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    $pathParts = explode('?', $this->uri);
    $this->uri = $pathParts[0];
  }

  private function setPostVars(): void
  {
    $this->postVars = json_decode(file_get_contents('php://input'), true) ?? [];
  }

  private function setQueryParams(): void
  {
    $this->queryParams = array_slice($_GET, 1);
  }

  public function getRouter(): Router
  {
    return $this->router;
  }

  public function getHttpMethod(): string
  {
    return $this->httpMethod;
  }

  public function getUri(): string
  {
    return $this->uri;
  }

  public function getQueryParams(): array
  {
    return $this->queryParams;
  }

  public function getPostVars(): array
  {
    return $this->postVars;
  }

  public function getHeaders(): array
  {
    return $this->headers;
  }
}
