<?php

class Autoloader
{
    public static function loader($class_name) {
        $filename = self::_getFilename($class_name);

        if (file_exists($filename)) {
            require_once $filename;
            if (method_exists($class_name, 'construct')) {
                $class_name::construct();
                return true;
            }
        }

        return false;
    }

    private static function _getFilename($class_name) {
        return ROOT . DIRECTORY_SEPARATOR .
            str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    }
}

spl_autoload_register('Autoloader::loader');