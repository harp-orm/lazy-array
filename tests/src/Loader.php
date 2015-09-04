<?php

namespace Harp\LazyArray\Test;

use Harp\LazyArray\LoaderInterface;

class Loader implements LoaderInterface
{
    private $items;
    private $loaded = false;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function load()
    {
        $this->loaded = true;

        return $this->items;
    }

    public function isLoaded()
    {
        return $this->loaded;
    }
}
