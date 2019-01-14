<?php

namespace Bootstrap;

/**
 * Bootstrap Class will be loaded on every request.
 */
abstract class Bootstrap
{

    private $routes;

    public function __construct()
    {
        session_start();
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    abstract protected function initRoutes();

    /**
     * Execute controllers based on the URL.
     *
     * @param string $url_path String containing the url path.
     */
    protected function run($url_path)
    {
        array_walk($this->routes, function ($route) use ($url_path) {
            if ($url_path === $route['route']) {
                $class = 'App\\Controllers\\' . ucfirst($route['controller']);
                $controller = new $class();
                $controller->$route['action']();
            }
        });
    }

    /**
     * Set the routes for the application.
     *
     * @param array $routes Array containing all routes for the application.
     */
    protected function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Returns the url path.
     *
     * @return string String containing the url path.
     */
    protected function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
