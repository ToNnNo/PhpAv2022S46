<?php

namespace App\Validator;

use App\Model\Product;

class ProductValidator
{
    private $errors = [];

    public function validate(Product $product): void
    {
        // tester que "name" ne soit pas vide
        $name = trim($product->getName());
        if( null == $name || '' == $name ) {
            $this->errors['name'][] = "Le nom est obligatoire";
        }

        $price = $product->getPrice();
        if( !filter_var($price, FILTER_VALIDATE_FLOAT) ) {
            $this->errors['price'][] = "Le prix doit être une valeur numérique";
        }

        if( null == $price || '' == $price ) {
            $this->errors['price'][] = "Le prix est obligatoire";
        }
    }

    public function isValid(): bool
    {
        return 0 === count($this->errors);
    }

    public function getError(): array
    {
        return $this->errors;
    }
}
