<?php

namespace App\Core;

use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    public function render($template, $parameters = [], $extends = 'base.phtml'): Response
    {
        // echappe xss pour les chaines de caractère ?
        extract(array_map(function($param){
            if(is_string($param)){
                return htmlentities($param);
            }

            return $param;
        }, $parameters));

        ob_start();
        require __DIR__ . "/../../template/" . $template;
        $blockbody = ob_get_clean();

        ob_start();
        require __DIR__ . "/../../template/" . $extends;
        $content = ob_get_clean();

        return new Response($content, Response::HTTP_OK);
    }
}
