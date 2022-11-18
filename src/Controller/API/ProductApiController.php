<?php

namespace App\Controller\API;

use App\Core\AbstractController;
use App\Model\Product;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductApiController extends AbstractController
{

    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();

        // SerializerBuilder utilise les design pattern Builder et Factory
        $jms = SerializerBuilder::create()->build();
        $json = $jms->serialize($products, 'json');

        // JsonResponse::fromJsonString est un Factory
        return JsonResponse::fromJsonString($json);

        // return new JsonResponse($products);
    }
}
