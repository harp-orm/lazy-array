<?php

namespace Harp\LazyArray\Test;

use PHPUnit_Framework_TestCase;
use Harp\LazyArray\LazyArray;
use ArrayObject;

/**
 * @coversDefaultClass Harp\LazyArray\LazyArray
 */
class LazyArrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getLoader
     * @covers ::isLoaded
     */
    public function testConstruct()
    {
        $models = [new Model('1'), new Model('2')];
        $loader = new Loader($models);

        $arr = new LazyArray(
            $loader,
            ArrayObject::ARRAY_AS_PROPS | ArrayObject::STD_PROP_LIST,
            'Harp\LazyArray\Test\TestArrayIterator'
        );

        $this->assertFalse($loader->isLoaded(), 'Should not be loaded when constructed');
        $this->assertFalse($arr->isLoaded(), 'Should not be loaded when constructed');

        $this->assertSame($models, $arr->getArrayCopy());
        $this->assertSame($loader, $arr->getLoader());

        $this->assertTrue($loader->isLoaded(), 'Should be loaded after first access');
        $this->assertTrue($arr->isLoaded(), 'Should be loaded after first access');

        $this->assertSame(
            ArrayObject::ARRAY_AS_PROPS | ArrayObject::STD_PROP_LIST,
            $arr->getFlags(),
            'Should pass flags to the underlying array object'
        );

        $this->assertSame(
            'Harp\LazyArray\Test\TestArrayIterator',
            $arr->getIteratorClass(),
            'Should pass IteratorClass to the underlying array object'
        );
    }

    /**
     * @covers ::load
     */
    public function testLoad()
    {
        $models = [new Model('1'), new Model('2')];
        $loader = new Loader($models);

        $arr = new LazyArray($loader);

        $this->assertSame($models, $arr->load());

        $this->assertTrue($loader->isLoaded(), 'Should call load() on the loader');
        $this->assertTrue($arr->isLoaded(), 'Should set loaded to true');

        $this->assertSame($models, $arr->getArrayCopy(), 'Should load the contents');
    }


    /**
     * @covers ::append
     */
    public function testAppend()
    {
        $loader = new Loader([]);
        $m1 = new Model('1');

        $arr = new LazyArray($loader);

        $arr->append($m1);

        $this->assertTrue($arr->isLoaded(), 'Should call load() for append()');
        $this->assertSame([$m1], $arr->getArrayCopy(), 'Should append properly');
    }

    /**
     * @covers ::count
     */
    public function testCount()
    {
        $loader = new Loader([new Model('1'), new Model('2'), new Model('3')]);

        $arr = new LazyArray($loader);

        $this->assertCount(3, $arr, 'Should implement countable properly');

        $this->assertTrue($arr->isLoaded(), 'Should call load() for count()');
    }

    /**
     * @covers ::asort
     */
    public function testAsort()
    {
        $array    = [1 => 10, 2 => 29, 3 => 3, 4 => 11];
        $expected = [1 => 10, 2 => 29, 3 => 3, 4 => 11];
        asort($expected);

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        $arr->asort();

        $this->assertTrue($arr->isLoaded(), 'Should call load() for asort()');

        $this->assertSame($expected, $arr->getArrayCopy(), 'Should sort properly with asort');
    }

    /**
     * @covers ::ksort
     */
    public function testKsort()
    {
        $array    = [3 => 3, 1 => 10, 4 => 11, 2 => 29];
        $expected = $array;
        ksort($expected);

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        $arr->ksort();

        $this->assertTrue($arr->isLoaded(), 'Should call load() for ksort()');

        $this->assertSame($expected, $arr->getArrayCopy(), 'Should sort properly with ksort');
    }

    /**
     * @covers ::natsort
     */
    public function testNatsort()
    {
        $array    = ['img10.png', 'img1.png', 'img2.png', 'img12.png'];
        $expected = $array;
        natsort($expected);

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        $arr->natsort();

        $this->assertTrue($arr->isLoaded(), 'Should call load() for natsort()');

        $this->assertSame($expected, $arr->getArrayCopy(), 'Should sort properly with natsort');
    }

    /**
     * @covers ::natcasesort
     */
    public function testNatcasesort()
    {
        $array    = ['Img10.png', 'iMg1.png', 'imG2.png', 'Img12.png'];
        $expected = $array;
        natcasesort($expected);

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        $arr->natcasesort();

        $this->assertTrue($arr->isLoaded(), 'Should call load() for natcasesort()');

        $this->assertSame($expected, $arr->getArrayCopy(), 'Should sort properly with natcasesort');
    }

    /**
     * @covers ::exchangeArray
     */
    public function testExchangeArray()
    {
        $array    = [1, 2, 3];
        $expected = [2, 3, 4];

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        $arr->exchangeArray($expected);

        $this->assertfalse($loader->isLoaded(), 'Should not call the loader load() method when calling exchangeArray');
        $this->assertTrue($arr->isLoaded(), 'Should mark as loaded when exchangeArray() is called');

        $this->assertSame($expected, $arr->getArrayCopy(), 'Should set the array correctly with exchangeArray');
    }

    /**
     * @covers ::getArrayCopy
     */
    public function testArrayCopy()
    {
        $array = [1, 2, 3];

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        $this->assertSame($array, $arr->getArrayCopy(), 'Should get the array correctly with getArrayCopy');

        $this->assertTrue($loader->isLoaded(), 'Should call the loader load() method when colling getArrayCopy');
        $this->assertTrue($arr->isLoaded(), 'Should mark as loaded when getArrayCopy() is called');
    }

    /**
     * @covers ::getIterator
     */
    public function testGetIterator()
    {
        $array = [1, 2, 3];

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        foreach ($arr as $i => $value) {
            $this->assertSame($array[$i], $value, 'Should return the correct values when iterating');
        }

        $this->assertTrue($loader->isLoaded(), 'Should call the loader load() method when calling getIterator');
        $this->assertTrue($arr->isLoaded(), 'Should mark as loaded when getIterator() is called');
    }

    /**
     * @covers ::offsetGet
     * @covers ::offsetSet
     * @covers ::offsetExists
     * @covers ::offsetUnset
     */
    public function testOffsetMethods()
    {
        $array = [1 => "img1", 2 => "img2", 3 => "img3"];

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        $this->assertEquals($array[1], $arr[1], 'Should return the correct value with offsetGet');
        $this->assertTrue(isset($arr[2]), 'Should return true for existing keys with offsetExists');
        $this->assertFalse(isset($arr[4]), 'Should return false for non-existing keys with offsetExists');
        unset($arr[3]);
        $this->assertFalse(isset($arr[3]), 'Should remove items with offsetUnset');

        $this->assertTrue($loader->isLoaded(), 'Should call the loader load() method when calling offset* methods');
        $this->assertTrue($arr->isLoaded(), 'Should mark as loaded when calling offset* methods');
    }

    /**
     * @covers ::serialize
     */
    public function testSerialize()
    {
        $array = [1 => "img1", 2 => "img2", 3 => "img3"];

        $loader = new Loader($array);

        $arr = new LazyArray($loader);

        $data = serialize($arr);

        $arr2 = unserialize($data);

        $this->assertTrue($loader->isLoaded(), 'Should call the loader load() serializing arrays');
        $this->assertSame($array, $arr2->getArrayCopy());
        $this->assertTrue($arr2->isLoaded(), 'Should call be loaded after serialization');
    }
}
