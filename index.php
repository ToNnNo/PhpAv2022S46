<?php

require __DIR__ . "/vendor/autoload.php";

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use \App\Core\App;

// Request
// quand le client demande une page (au travers d'une url), il faut retrouver le controller qui sera en charge de fournir la réponse (vue)
// Pour réaliser cette association on utilise une "route" qui fait le lien entre l'url et le controller

// Traitement (Controler (-> Model) -> Vue)
// Response

$request = Request::createFromGlobals();
$app = new App($request);

/** @var Response $response */
$response = $app->run();
$response->send(); // affiche le résultat au format html
