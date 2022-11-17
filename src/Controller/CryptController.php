<?php

namespace App\Controller;

use App\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CryptController extends AbstractController
{

    public function index(): Response
    {

        return $this->render('crypt/index.phtml');
    }

}
