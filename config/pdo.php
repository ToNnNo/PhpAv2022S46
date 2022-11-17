<?php

return [
    'dev' => ['connector' => 'mysql', 'db' => 'easy-access-english', 'host' => 'localhost', 'port' => '8889', 'username' => 'root', 'password' => 'root'],
    'prod' => ['connector' => 'mysql', 'db' => 'dbprod', 'host' => 'localhost', 'port' => '8889', 'username' => 'root', 'password' => 'root'],
    'test' => ['connector' => 'sqlite', 'path' => '/var/db.sqlite'],
];
