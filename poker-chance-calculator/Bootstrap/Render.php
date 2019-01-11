<?php

namespace Bootstrap;

class Render {

  protected $view;
  protected $action;

  public function __construct() {
    $this->view = new \stdClass;
  }

  public function render($action, $layout = TRUE) {
    $this->action = $action;

    ($layout)
      ? include_once '../App/Views/base.phtml'
      : $this->content();
  }

  public function content() {
    $current_class = get_class($this);
    $class_name = strtolower(str_replace('App\\Controllers\\', '', $current_class));

    include_once '../App/Views/' . $class_name . '/' . $this->action . '.phtml';
  }
}