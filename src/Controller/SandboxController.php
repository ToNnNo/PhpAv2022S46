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
            'name' => "<b>John</b>"
        ]);
    }

    public function users(): Response
    {
        $users = [
            ['id' => 1, 'name' => "John Doe", 'job' => "Dev. Symfony"],
            ['id' => 2, 'name' => "Jane Doe", 'job' => "Dev. Angular"],
            ['id' => 3, 'name' => "Eduard Doe", 'job' => "Infographiste"],
        ];

        return $this->render('sandbox/users.phtml', [
            'users' => $users, // je transmet à la vue la variable $users
        ]);
    }
}
