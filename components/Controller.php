<?php

namespace components;

class Controller
{
    protected $view;

    public function __construct($default_template) {
        $this->view = new View($default_template);
    }

    public function notFoundAction() {
        $this->view->render();
    }
}