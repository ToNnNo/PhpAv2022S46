<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\Product;
use App\Service\Token;
use App\Validator\ProductValidator;
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
        // $request est une instance de la classe Request
        // ->request est une instance de la classe InputBag
        // ->request détient les valeurs de $_POST
        // On met dans $data les valeurs de request (request=$_POST)
        $data = $request->request;
        $productValidator = new ProductValidator();
        $token = new Token('product_token');
        $product = new Product();
        $product
            ->setName($data->get('name'))
            ->setPrice($data->get('price'))
            ->setDescription($data->get('description'))
            ->setDate(new \DateTime());

        $errors = [];

        // compare que la method HTTP est égale à POST
        if("POST" === $request->getMethod() ) {

            if($token->isValid($data->get('token'), 'product_token')) {
                $productValidator->validate($product);
                $errors = $productValidator->getError();

                if ($productValidator->isValid()) {
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($product);
                    $em->flush();

                    // Fait une redirection vers une autre page
                    return new RedirectResponse('/orm');
                }
            } else {
                $errors['token'][] = "Le token n'est pas valide";
            }
        }

        return $this->render('orm/edit.phtml', [
            'product' => $product,
            'errors' => $errors,
            'token' => $token->getToken()
        ]);
    }
}
