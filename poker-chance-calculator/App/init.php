<?php

namespace App;

use Bootstrap\Bootstrap;

/**
 * Init Class is responsible to define routes for the application.
 */
class Init extends Bootstrap
{

    /**
     * Creates and set the routes.
     */
    public function initRoutes()
    {
        $routes = [
            'home' => [
                'route' => '/',
                'controller' => 'index',
                'action' => 'index'
            ],
            'draft' => [
                'route' => '/draft',
                'controller' => 'index',
                'action' => 'draft'
            ],
            'success' => [
                'route' => '/success',
                'controller' => 'index',
                'action' => 'success'
            ]
        ];

        $this->setRoutes($routes);
    }
}
