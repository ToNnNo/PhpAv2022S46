<?php

namespace App\Controller;

use App\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SandboxController extends AbstractController
{

    public function index(): Response
    {
        $content = file_get_contents("template/sandbox/index.html");

        return new Response($content);
    }

    public function hello(): Response
    {
        return $this->render('sandbox/hello.phtml', [
            'blocktitle' => "Hello World",
            'name' => "John"
        ]);
    }
}
