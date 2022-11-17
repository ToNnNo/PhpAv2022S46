<?php

namespace App\Core;

use App\Exception\InternalErrorException;
use App\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class App
{
    private $request;

    private $routes;

    public function __construct(Request $request)
    {
        $session = new Session();
        $session->start();
        $request->setSession($session);

        $this->request = $request;
        $this->routes = require __DIR__ . "/../../routes.php";
    }

    public function run(): Response
    {
        try{
            $controller = $this->getController();

            $response = $this->instanciateController($controller);

        } catch (NotFoundException $e) {
            $response = new Response("<pre>".$e."</pre>", 404);
        } catch (InternalErrorException $e) {
            $response = new Response("<pre>".$e."</pre>", 500);
        }

        return $response;
    }

    private function getController(): string
    {
        // récupérer la route de la requête
        $path = $this->request->getPathInfo();

        // lister toutes les routes de l'application
        $paths = array_column($this->routes, 'route');

        // rechercher la route client parmi celles définies dans l'application (routes.php)
        // sinon retourner une 404
        if( ($key = array_search($path, $paths)) === false ) {
            throw new NotFoundException("Cette route n'existe pas");
        }

        // récupérer le controller associé à une route
        return $this->routes[$key]['controller'];
    }

    private function instanciateController(string $controller): Response
    {
        // spliter le controller pour en récupérer la classe et la méthode
        list($class, $method) = explode("::", $controller);

        // vérifier que la classe existe, sinon erreur 500
        // sprintf -> fait des templates de chaine de caractère
        if(!class_exists($class)) {
            throw new InternalErrorException(sprintf("La classe \"%s\" n'existe pas", $class));
        }

        // vérifier que la methode existe dans la classe, sinon erreur 500
        if(!method_exists($class, $method)) {
            throw new InternalErrorException(sprintf("La method \"%s\" n'existe pas dans la classe \"%s\"", $method, $class));
        }

        // instancier le controller
        $instance = new $class;

        // récupérer la réponse et la retourner
        return call_user_func_array([$instance, $method], [$this->request]);
    }
}
