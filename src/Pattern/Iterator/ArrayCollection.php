<?php

namespace App\Pattern\Iterator;

class ArrayCollection implements \Iterator, \Countable
{
    private $data = [];
    private $index = 0;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function add($item): self
    {
        // array_push($this->data, $item);
        $this->data[] = $item;
        return $this;
    }

    public function get(int $index)
    {
        return $this->data[$index];
    }

    public function remove(int $index): self
    {
        unset($this->data[$index]);
        $this->data = array_values($this->data);
        return $this;
    }

    // récupère une valeur
    public function current()
    {
        return $this->data[$this->index];
    }

    // passe à la valeur suivante
    public function next(): void
    {
        $this->index += 1;
    }

    // récupère la valeur de la clé
    public function key()
    {
        return $this->index;
    }

    // vérifie qu'une autre valeur existe
    public function valid(): bool
    {
        return isset($this->data[$this->index]);
    }

    // reviens au début des données
    public function rewind(): void
    {
        $this->index = 0;
    }

    public function count(): int
    {
        return count($this->data);
    }
}
