<?php

namespace components;

class Authorization
{
    private static $_user;

    public static function construct() {
        session_start();
        self::$_user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public static function getUser() {
        return self::$_user;
    }

    public static function logIn($username) {
        $_SESSION['user'] = $username;
    }

    public static function logOut() {
        unset($_SESSION['user']);
    }

    public static function isAdmin() {
        return self::$_user == 'admin';
    }

}