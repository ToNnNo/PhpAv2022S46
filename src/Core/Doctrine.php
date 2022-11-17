<?php

namespace App\Core;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMSetup;

class Doctrine
{
    private $entityManager;

    public function __construct()
    {
        // https://www.doctrine-project.org/projects/doctrine-orm/en/2.13/tutorials/getting-started.html#getting-started-with-doctrine

        // createAnnotationMetadataConfiguration() -> lit les metadonnées (sous forme d'annotation) des models pour pouvoir créer les tables
        $config = ORMSetup::createAnnotationMetadataConfiguration([ __DIR__ . "/../Model/"], true);

        $dbParams = [
            'driver' => 'pdo_mysql',
            'user' => 'root',
            'password' => 'root',
            // 'host' => 'locahost:3306',
            'host' => 'localhost:8889',
            // 'dbname' => 'easyaccessenglish'
            'dbname' => 'easy-access-english'
        ];

        try {
            // EntityManager -> Objet qui fait le lien entre l'application et la base de données
            // create() -> Etablie la connexion vers la base de données
            $this->entityManager = EntityManager::create($dbParams, $config); // Factory = délègue la création d'une instance à une methode spécifique
        } catch(ORMException $e) {
            echo $e;
        }
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function getRepository($entityname): EntityRepository
    {
        return $this->entityManager->getRepository($entityname);
    }
}
