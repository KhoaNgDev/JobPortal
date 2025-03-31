<?php

namespace App\Iterators;

use Iterator;

class CityIterator implements Iterator
{
    private $cities;
    private $position = 0;

    public function __construct($cities)
    {
        $this->cities = $cities;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->cities[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->cities[$this->position]);
    }
}
