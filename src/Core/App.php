<?php

namespace App\Core;

use App\Exception\InternalErrorException;
use App\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    private $request;

    private $routes;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->routes = require __DIR__ . "/../../routes.php";
    }

    public function run(): Response
    {
        $response = null;

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

        // rechercher la route parmi celle défini dans l'application (routes.php)
        $paths = array_column($this->routes, 'route');

        // sinon retourner une 404
        if( ($key = array_search($path, $paths)) === false ) {
            throw new NotFoundException("Cette route n'existe pas");
        }

        return $this->routes[$key]['controller'];
    }

    private function instanciateController(string $controller): Response
    {
        // instancier le controller & récupérer la réponse pour la retourner
        list($class, $method) = explode("::", $controller);

        if(!class_exists($class)) {
            throw new InternalErrorException(sprintf("La classe \"%s\" n'existe pas", $class));
        }

        if(!method_exists($class, $method)) {
            throw new InternalErrorException(sprintf("La method \"%s\" n'existe pas dans la classe \"%s\"", $method, $class));
        }

        $instance = new $class;
        return call_user_func_array([$instance, $method], [$this->request]);
    }
}
