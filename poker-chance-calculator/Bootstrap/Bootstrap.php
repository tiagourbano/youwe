<?php

namespace Bootstrap;

abstract class Bootstrap {
  
  private $routes;
  
  public function __construct() {
    session_start();
    $this->initRoutes();
    $this->run($this->getUrl());
  }

  abstract protected function initRoutes();

  protected function run($url_path) {
    array_walk($this->routes, function($route) use($url_path) {
      if ($url_path === $route['route']) {
        $class = 'App\\Controllers\\' . ucfirst($route['controller']);
        $controller = new $class;
        $controller->$route['action']();
      }
    });
  }

  protected function setRoutes(array $routes) {
    $this->routes = $routes;
  }

  protected function getUrl() {
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  }

}
