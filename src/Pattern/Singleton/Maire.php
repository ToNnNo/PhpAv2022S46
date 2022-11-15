<?php

namespace App\Pattern\Singleton;

class Maire extends Citoyen
{

    private static $instance = null;

    private function __construct()
    {
        parent::__construct(null); // fait appel au contructeur parent (Citoyen)
    }

    private function __clone() {} // Prototype

    private function __wakeup() // serialization = transforme un objet en string (ex: json)
    {
        throw new \Exception('cannot be unserialize');
    }

    public static function getInstance(): Maire
    {
        if( null == self::$instance ) {
            self::$instance = new Maire();
        }

        return self::$instance;
    }
}
