<?php

namespace components;

class Router
{
    private $_routes;

    public function __construct() {
        $this->_routes = include(ROOT . '/config/routes.php');
    }

    public function run() {
        $uri = $this->_getURI();
        $action_found = false;

        foreach ($this->_routes as $uriPattern => $path) {

            if (preg_match("~^$uriPattern$~", $uri, $matches)) {

                $segments = explode('/', $path);

                $controller_name = array_shift($segments);
                $controller_class = $controller_name . 'Controller';
                $controller_class = 'controllers\\' . ucfirst($controller_class);

                $action_name = array_shift($segments);
                $action_method = $action_name . 'Action';

                if ($segments) {
                    array_shift($matches); // remove first element
                    $request_data = array_combine($segments, $matches);
                    Request::setRequestData($request_data);
                }

                if (method_exists($controller_class, $action_method)) {
                    $controllerObject = new $controller_class(
                        "$controller_name/$action_name"
                    );
                    $controllerObject->$action_method();
                    $action_found = true;
                    break;
                }
            }

        }

        // 404 page
        if (!$action_found) {
            $controllerObject = new Controller('layout/404');
            $controllerObject->notFoundAction();
        }
    }

    private function _getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $parsed = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
            return trim($parsed, '/');
        }
    }
}