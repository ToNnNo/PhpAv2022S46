<?php

return [
    ["route" => "/", "controller" => "\App\Controller\SandboxController::index"],
    ["route" => "/hello", "controller" => "\App\Controller\SandboxController::hello"],
    ["route" => "/list-user", "controller" => "\App\Controller\SandboxController::users"],

    ["route" => "/design-pattern/singleton", "controller" => "\App\Controller\DesignPatternController::singleton"],
    ["route" => "/design-pattern/iterator", "controller" => "\App\Controller\DesignPatternController::iterator"],
    ["route" => "/design-pattern/factory", "controller" => "\App\Controller\DesignPatternController::factory"],

    ["route" => "/pdf", "controller" => "\App\Controller\PDFController::index"],

    ["route" => "/orm/example", "controller" => "\App\Controller\ORMController::example"],
    ["route" => "/orm", "controller" => "\App\Controller\ORMController::index"],
    ["route" => "/orm/add", "controller" => "\App\Controller\ORMController::add"],

    ["route" => "/crypt", "controller" => "\App\Controller\CryptController::index"],
    ["route" => "/crypt/list", "controller" => "\App\Controller\CryptController::list"],
    ["route" => "/crypt/read", "controller" => "\App\Controller\CryptController::read"],

    ["route" => "/api/product", "controller" => "\App\Controller\API\ProductApiController::index"],

    // 500
    ["route" => "/castle", "controller" => "\App\Controller\SandboxController::castle"],
    ["route" => "/user", "controller" => "\App\Controller\UserController::index"],
];
