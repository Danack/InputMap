<?php

declare(strict_types=1);

namespace VarMapTest;

use VarMap\ArrayVarMap;
use VarMap\Psr7VarMap;
use VarMap\Exception\VariableMissingException;

class ArrayVarMapTest extends BaseTestCase
{
    public function testArrayInputMapWorks()
    {
        $key = 'foo';
        $value = 'bar';
        $varMap = new ArrayVarMap([$key => $value, 'someother' => 'value']);
        $fooValue = $varMap->get('foo');
        $this->assertEquals($value, $fooValue);
    }

    public function testArrayInputMapException()
    {
        $varMap = new ArrayVarMap(['zot' => 'fot']);
        $this->expectException(VariableMissingException::class);
        $varMap->get('foo');
    }

    public function testArrayInputMapHas()
    {
        $varMap = new ArrayVarMap(['zot' => 'fot']);
        $this->assertTrue($varMap->has('zot'));
        $this->assertFalse($varMap->has('quux'));
    }

    public function testArrayInputMapGetWithDefault()
    {
        $varMap = new ArrayVarMap(['zot' => 'fot']);
        $this->assertEquals('fot', $varMap->getWithDefault('zot', null));
        $this->assertNull($varMap->getWithDefault('quux', null));
    }

    public function testArrayInputMapGetNames()
    {
        $varMap = new ArrayVarMap(['zot' => 'fot']);
        $this->assertEquals(['zot'], $varMap->getNames());
    }
}
