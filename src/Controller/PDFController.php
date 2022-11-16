<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Service\PDFCreator;
use Symfony\Component\HttpFoundation\Response;

class PDFController extends AbstractController
{

    public function index(): Response
    {
        $source = dirname(__DIR__, 2). "/template/pdf/source/document.php";
        $client = "abergel";
        $pdfCreator = new PDFCreator();
        // $pdfCreator->display($source, "formation-php-av-".$client.".pdf");

        // $pdfCreator->download($source, "formation-php-av.pdf");

        $path = dirname(__DIR__, 2)."/public/pdf/formation-php-av.pdf";
        $pdfCreator->save($source, $path);

        return $this->render('pdf/index.phtml');
    }

}
