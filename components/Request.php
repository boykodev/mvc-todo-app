<?php

namespace components;

class Request
{
    private static $_params = array();

    /**
     * Static constructor for GET/POST parse
     */
    public static function construct() {
        $request = array_merge($_GET, $_POST);

        foreach ($request as $key => $value) {
            self::$_params[$key] = $value;
        }
    }

    public static function isPost() {
        return (bool) $_POST;
    }

    public static function setRequestData($data) {
        foreach ($data as $key => $value) {
            $param = str_replace(':' , '', $key);
            self::$_params[$param] = $value;
        }
    }

    public static function getParam($key, $default = null) {
        if (isset(self::$_params[$key])) {
            return self::$_params[$key];
        } else {
            return $default;
        }
    }

    public static function getParams() {
        return self::$_params;
    }
}