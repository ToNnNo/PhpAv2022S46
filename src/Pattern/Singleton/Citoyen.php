<?php

namespace App\Pattern\Singleton;

class Citoyen
{
    private ?string $name;

    public function __construct(?string $name) { // ?string => la valeur peut être une chaine de caractère ou null
        $this->name = $name;
    }

    /**
     * getter => accesseur
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * setter => mutateur
     */
    public function setName($name): Citoyen {
        $this->name = $name;
        return $this;
    }
}
