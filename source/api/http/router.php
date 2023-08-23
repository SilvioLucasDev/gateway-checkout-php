<?php
  require_once './api/http/request.php';
  require_once './api/http/response.php';

  class Router {
    private string  $url;
    private string  $prefix;
    private array   $routes;
    private Request $request;
    private array   $headers;

    public function __construct(string $url, Request $request) {
      $this->request = $request;
      $this->url = $url;
      $this->serPrefix();
    }

    public function serPrefix(): void {
      $parseUrl = parse_url($this->url);
      $this->prefix = $parseUrl['path'] ?? '';
    }

    private function addRoute(string $method, string $route, array $params): void {
      foreach($params as $key => $value) {
        if ($value instanceof Closure) {
          $params['controller'] = $value;
          unset($params[$key]);
          continue;
        }
      }
      $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
      $this->routes[$patternRoute][$method] = $params;
    }

    public function get(string $route, array $params = []) {
      return $this->addRoute('GET', $route, $params);
    }

    public function post(string $route, array $params = []) {
      return $this->addRoute('POST', $route, $params);
    }

    public function put(string $route, array $params = []) {
      return $this->addRoute('PUT', $route, $params);
    }

    public function delete(string $route, array $params = []) {
      return $this->addRoute('DELETE', $route, $params);
    }

    private function getUri(): string {
      $uri = $this->request->getUri();
      $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
  	  return end($xUri);
    }

    private function getRoute() {
      $uri = $this->getUri();
      $httpMethod = $this->request->getHttpMethod();

      foreach ($this->routes as $patternRoute => $methods){
        if(preg_match($patternRoute, $uri)) {
          if($methods[$httpMethod]) {
            return $methods[$httpMethod];
          }
          throw new Exception("Método não permitido", 405);
        }
      }
      throw new Exception("URL não encontrada", 404);
    }

    public function run() {
      try{
        $route = $this->getRoute();

        if(!isset($route['controller'])) {
          throw new Exception("A URL não pôde ser processada", 500);
        }

        $args = [];
        return call_user_func_array($route['controller'], $args);

      } catch (Exception $e) {
        return new Response($e->getCode(), $e->getMessage());
      }
    }
  }
