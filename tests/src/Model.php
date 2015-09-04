<?php

namespace Harp\LazyArray\Test;

class Model
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function compare(Model $m1, Model $m2)
    {
        return (int) $m1->name() - (int) $m2->name();
    }
}
