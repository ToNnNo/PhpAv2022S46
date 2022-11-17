<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\Product;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

    public function add(Request $request): Response
    {
        $data = $request->request;
        $product = new Product();
        $product
            ->setName($data->get('name'))
            ->setPrice($data->get('price'))
            ->setDescription($data->get('description'))
            ->setDate(new \DateTime());

        if("POST" === $request->getMethod()) {

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($product);
            $em->flush();

            return new RedirectResponse('/orm');
        }

        $token = password_hash('product_token', PASSWORD_DEFAULT);
        session_start();
        $_SESSION['token'] = $token;

        return $this->render('orm/edit.phtml', [
            'product' => $product,
            'token' => $token,
        ]);
    }
}
