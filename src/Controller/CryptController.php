<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Exception\NotFoundException;
use App\Model\Secret;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CryptController extends AbstractController
{

    public function index(): Response
    {
        $message = "Quand je retire mes lunettes, je suis Superman";
        $secret = new Secret();

        $publicKey = file_get_contents(dirname(__DIR__, 2). "/key.rsa.pub");
        openssl_public_encrypt($message, $crypted, $publicKey);

        $secret->setMessage($crypted);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($secret);
        $em->flush();

        return $this->render('crypt/index.phtml', [
            'secret' => $secret
        ]);
    }

    public function list(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Secret::class);
        $secrets = $repository->findAll();

        return $this->render('crypt/list.phtml', [
            "secrets" => $secrets
        ]);
    }

    public function read(Request $request): Response
    {
        $id = $request->get('id', 0);
        $repository = $this->getDoctrine()->getRepository(Secret::class);
        // find() protège contre les injections SQL
        $secret = $repository->find($id); // SELECT * FROM secret WHERE id = ?

        if(!$secret) {
            throw new NotFoundException("La ressource n'existe pas");
        }

        $strKey = file_get_contents(dirname(__DIR__, 2). "/key.rsa");
        $privateKey = openssl_pkey_get_private($strKey, "commentestvotreblanquette");
        openssl_private_decrypt($secret->getMessage(), $decrypted, $privateKey);

        return $this->render('crypt/read.phtml', [
            "decrypted" => $decrypted
        ]);
    }

}
