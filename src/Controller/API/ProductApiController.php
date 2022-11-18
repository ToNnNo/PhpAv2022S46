<?php

namespace App\Controller\API;

use App\Core\AbstractController;
use App\Model\Product;
use App\Validator\ProductValidator;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductApiController extends AbstractController
{
    private $jms;
    private $request;

    public function __construct()
    {
        // SerializerBuilder utilise les design pattern Builder et Factory
        $this->jms = SerializerBuilder::create()->build();
    }

    public function index(Request $request): Response
    {
        $this->request = $request;

        switch ($request->getMethod()) {
            case 'GET':
                return $this->list();
            case 'POST':
                return $this->add();
            case 'DELETE':
                return $this->remove();
            default:
                return new JsonResponse([], Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        $json = $this->jms->serialize($products, 'json');

        // JsonResponse::fromJsonString est un Factory
        return JsonResponse::fromJsonString($json);

        // return new JsonResponse($products);
    }

    public function add(): Response
    {
        // Récupère les données dans le body de HTTP
        $data = $this->request->getContent();

        // Construit un Produit (instancier)
        $product = $this->jms->deserialize($data, Product::class, 'json');
        $product->setDate(new \DateTime());

        // Valide les données du produit
        $validator = new ProductValidator();
        $validator->validate($product);

        // Retourne une erreur si le produit n'est pas valide
        if( !$validator->isValid() ) {
            $data = [
                'errors' => $validator->getError()
            ];

            return new JsonResponse($data, Response::HTTP_BAD_REQUEST);
        }

        // Enregistre le produit
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();

        $json = $this->jms->serialize($product, 'json');
        return JsonResponse::fromJsonString($json, Response::HTTP_CREATED);
    }

    public function remove(): Response
    {
        $id = $this->request->query->get('id', false);

        if( !$id ) {
            $data = [
                'errors' => "No data found"
            ];

            return new JsonResponse($data, Response::HTTP_BAD_REQUEST);
        }

        $repository = $this->getDoctrine()->getRepository(Product::class);

        $product = $repository->find($id);

        if(!$product) {
            $data = [
                'errors' => "No data found"
            ];

            return new JsonResponse($data, Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($product);
        $em->flush();

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
