<?php

return [
    //'dev' => ['connector' => 'mysql', 'db' => 'easyaccessenglish', 'host' => 'localhost', 'port' => '3306', 'username' => 'root', 'password' => ''],
    'dev' => ['connector' => 'mysql', 'db' => 'easy-access-english', 'host' => 'localhost', 'port' => '8889', 'username' => 'root', 'password' => 'root'],
    'prod' => ['connector' => 'mysql', 'db' => 'dbprod', 'host' => 'localhost', 'port' => '8889', 'username' => 'root', 'password' => 'root'],
    'test' => ['connector' => 'sqlite', 'path' => '/var/db.sqlite'],
];
