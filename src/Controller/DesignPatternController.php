<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Pattern\Factory\PDOFactory;
use App\Pattern\Iterator\ArrayCollection;
use App\Pattern\Singleton\Citoyen;
use App\Pattern\Singleton\Maire;
use Symfony\Component\HttpFoundation\Response;

class DesignPatternController extends AbstractController
{

    public function singleton(): Response
    {
        $marc = new Citoyen('Marc');
        $marc2 = new Citoyen('Marc');
        $laure = new Citoyen('Laure');

        $maire = Maire::getInstance();
        $maire->setName('Mayor John');

        $adjoint = Maire::getInstance();

        return $this->render('design-pattern/singleton.phtml', [
            'marc2' => $marc2,
            'marc' => $marc,
            'laure' => $laure,
            'maire' => $maire,
            'adjoint' => $adjoint
        ]);
    }

    public function iterator(): Response
    {
        $collection = new ArrayCollection();
        $collection
            ->add(new Citoyen('Marc'))
            ->add(new Citoyen('Laure'))
            ->add(new Citoyen('Alexandre'))
            ->add(new Citoyen('Marie'))
            ->add(new Citoyen('Sophie'));

        $collection->remove(3);

        return $this->render('design-pattern/iterator.phtml', [
            'collection' => $collection
        ]);
    }

    public function factory(): Response
    {
        $pdo = PDOFactory::createConnectionByEnvironnement('dev');
        $stmt = $pdo->query('select * from product');
        $products = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $fmt = new \NumberFormatter('fr_FR', \NumberFormatter::CURRENCY);
        $datefmt = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);

        return $this->render('design-pattern/factory.phtml', [
            "products" => $products,
            "fmt" => $fmt,
            "datefmt" => $datefmt
        ]);
    }

}
