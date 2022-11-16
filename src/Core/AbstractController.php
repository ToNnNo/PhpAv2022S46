<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    private $doctrine = null;

    public function getDoctrine()
    {
        if( null == $this->doctrine ) {
            $this->doctrine = new Doctrine();
        }

        return $this->doctrine;
    }

    public function render($template, $parameters = [], $extends = 'base.phtml'): Response
    {
        // extract => crée des variables php à partir des valeurs d'un tableau (parameters)
        // array_map => parcourir l'ensemble des valeurs d'un tableau pour y appliquer une fonction
        // (appliquer htmlentities sur les valeurs qui sont des chaines de caractères)
        extract(array_map(
            function($param){
                if(is_string($param)){
                    return htmlentities($param); // Protection XSS: transforme les caractères sensibles (< et >) en entité HTML
                }

                return $param;
            }, $parameters)
        );

        ob_start(); // demande la réservation d'un espace mémoire et y stocke toutes les actions suivante
        require __DIR__ . "/../../template/" . $template; // interprète le fichier et on le met en mémoire
        $blockbody = ob_get_clean(); // libérer la mémoire et récupérer le contenu stocké

        ob_start();
        require __DIR__ . "/../../template/" . $extends;
        $content = ob_get_clean();

        return new Response($content, Response::HTTP_OK);
    }
}
