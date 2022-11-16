<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\Product;
use Symfony\Component\HttpFoundation\Response;

class ORMController extends AbstractController
{

    public function example(): Response
    {
        $product = new Product();
        $product
            ->setName('Peluche Bouftou')
            ->setPrice(9.99)
            ->setDescription("Petite pelouche très douce blanche et bleu représentant un bouftou")
            ->setDate(new \DateTime())
        ;

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();

        return $this->render('orm/example.phtml');
    }

    public function index(): Response
    {
        // repository est l'objet qui permet de créer et/ou d'utiliser des méthodes faisant des requêtes de type SELECT
        $repository = $this->getDoctrine()->getEntityManager()->getRepository(Product::class);

        $products = $repository->findAll(); // findAll -> SELECT * FROM product

        // var_dump($products);

        return $this->render('orm/index.phtml', [
            'products' => $products
        ]);
    }
}
