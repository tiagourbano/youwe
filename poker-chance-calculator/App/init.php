<?php
namespace App;

use Bootstrap\Bootstrap;

class Init extends Bootstrap {
  
  public function initRoutes() {
    $routes_array = [
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
    
    $this->setRoutes($routes_array);
  }

}
