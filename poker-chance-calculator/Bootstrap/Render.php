<?php

namespace Bootstrap;

/**
 * Render Class is responsible to render the HTML for the pages.
 */
class Render
{

    protected $view;
    protected $action;
    protected $baseDir;

    public function __construct()
    {
        $this->view = new \stdClass();
        $this->baseDir = dirname(dirname(__FILE__));
    }

    /**
     * Renderize the HTML.
     *
     * Render the HTML content, if $layout is false will removed the headers.
     *
     * @param string $action The name of the method that will be rendered.
     * @param boolean $layout Render the entire HTML (header, body, style, script).
     *  Default value is true
     */
    public function render($action, $layout = true)
    {
        $this->action = $action;

        ($layout)
          ? include_once $this->baseDir . '/App/Views/base.phtml'
          : $this->content();
    }

    /**
     * Renderize the specific part of the HTML.
     *
     * Render the HTML content based on the Class and Method
     */
    public function content()
    {
        $current_class = get_class($this);
        $class_name = strtolower(str_replace('App\\Controllers\\', '', $current_class));

        include_once $this->baseDir . '/App/Views/' . $class_name . '/' . $this->action . '.phtml';
    }
}
