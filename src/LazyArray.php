<?php

namespace Harp\LazyArray;

use ArrayObject;

/**
 * An array object class that loads its contents only when requested
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class LazyArray extends ArrayObject
{
    /**
     * @var boolean
     */
    private $loaded = false;

    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @param LoaderInterface $loader
     * @param integer         $flags
     * @param string          $iterator_class
     */
    public function __construct(LoaderInterface $loader, $flags = 0, $iterator_class = "ArrayIterator")
    {
        $this->loader = $loader;

        parent::__construct([], $flags, $iterator_class);
    }

    /**
     * @return boolean
     */
    public function isLoaded()
    {
        return $this->loaded;
    }

    /**
     * Call "load" on the loader. Initialize this array object with the result and return the array
     *
     * @return array|null
     */
    public function load()
    {
        if (false === $this->loaded) {

            $items = $this->loader->load();

            $this->exchangeArray($items);

            return $items;
        }
    }

    /**
     * @return LoaderInterface
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * @param  mixed $item
     */
    public function append($item)
    {
        $this->load();

        parent::append($item);
    }

    /**
     * @return integer
     */
    public function count()
    {
        $this->load();

        return parent::count();
    }

    public function asort()
    {
        $this->load();

        return parent::asort();
    }

    /**
     * @param  mixed $input
     * @return mixed         old array
     */
    public function exchangeArray($input)
    {
        $this->loaded = true;

        return parent::exchangeArray($input);
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $this->load();

        return parent::getArrayCopy();
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        $this->load();

        return parent::getIterator();
    }

    public function ksort()
    {
        $this->load();

        parent::ksort();
    }

    public function natcasesort()
    {
        $this->load();

        parent::natcasesort();
    }

    public function natsort()
    {
        $this->load();

        parent::natsort();
    }

    /**
     * @param  mixed $index
     * @return boolean
     */
    public function offsetExists($index)
    {
        $this->load();

        return parent::offsetExists($index);
    }

    /**
     * @param  mixed $index
     * @return mixed
     */
    public function offsetGet($index)
    {
        $this->load();

        return parent::offsetGet($index);
    }

    /**
     * @param  mixed $index
     * @param  mixed $item
     */
    public function offsetSet($index, $item)
    {
        $this->load();

        parent::offsetSet($index, $item);
    }

    /**
     * @param  mixed $index
     */
    public function offsetUnset($index)
    {
        $this->load();

        parent::offsetUnset($index);
    }

    /**
     * @param  callable $cmp
     */
    public function uasort($cmp)
    {
        $this->load();

        parent::uasort($cmp);
    }

    /**
     * @param  callable $cmp
     */
    public function uksort($cmp)
    {
        $this->load();

        parent::uksort($cmp);
    }

    /**
     * @return string
     */
    public function serialize()
    {
        $this->load();

        return parent::serialize();
    }
}
