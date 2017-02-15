<?php

use components\Router;

class App
{
    private $_settings;

    public function __construct() {
        $this->_settings = include(ROOT . '/config/settings.php');
    }

    public function run() {
        if ($this->_getSetting('debug')) {
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
        }

        $this->_initAutoloader();
        $this->_initRouter();
    }

    private function _initAutoloader() {
        require_once ROOT . '/components/Autoloader.php';
    }

    private function _initRouter() {
        $router = new Router();
        $router->run();
    }

    private function _getSetting($setting) {
        if (isset($this->_settings[$setting])) {
            return $this->_settings[$setting];
        } else {
            return null;
        }
    }
}