<?php
/**
 * Created by PhpStorm.
 * User: Serge
 * Date: 2/14/17
 * Time: 04:43
 */

namespace components;


class Database
{
    private static $_instance;

    public static function getInstance() {
        if (!self::$_instance) {
            $params = include(ROOT . '/config/database.php');
            try {
                self::$_instance = new \PDO(
                    sprintf('mysql:host=%s;dbname=%s',
                        $params['host'], $params['dbname']
                    ),
                    $params['user'], $params['pass']
                );
            } catch (\PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }

        }

        return self::$_instance;
    }
}