<?php

namespace controllers;

use components\Controller;

class IndexController extends Controller {
    public function indexAction() {
        $this->view->page = 'home';
        $this->view->render();
    }
}