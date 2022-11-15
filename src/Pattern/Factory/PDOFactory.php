<?php

namespace App\Pattern\Factory;

class PDOFactory
{

    public static function createConnectionByEnvironnement($env): \PDO
    {
        $config = require __DIR__ . '/../../../config/pdo.php';

        $params = $config[$env];

        $pdo = new \PDO($params['connector'].':dbname='.$params['db'].';host='.$params['host'].':'.$params['port'], $params['username'], $params['password']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);

        return $pdo;
    }

}
