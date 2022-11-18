<?php

use \PHPUnit\Framework\TestCase;
use \App\Utils\Calculatrice;

class CalculatriceTest extends TestCase
{

    private $calculatrice;

    // method qui s'execute avant chacun des tests de notre classe
    // appelé automatiquement
    public function setUp(): void
    {
        $this->calculatrice = new Calculatrice();
    }

    public function testHasSommeMethod()
    {
        $this->assertTrue(
            method_exists($this->calculatrice, 'somme'),
            'Class does not have method "somme()"'
        );
    }

    public function testSomme()
    {
        $resultat = $this->calculatrice->somme(1, 2, 3, 4, 5);

        $this->assertEquals(15, $resultat);

        // $this->markTestIncomplete("Ce test n'est pas encore terminé");
    }

}
