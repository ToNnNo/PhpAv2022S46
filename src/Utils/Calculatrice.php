<?php

namespace App\Utils;

class Calculatrice
{

    public function somme(...$values)
    {
        $resultat = 0;

        foreach($values as $value) {
            $resultat += $value;
        }

        return $resultat;
    }
}
