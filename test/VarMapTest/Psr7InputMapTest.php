<?php

declare(strict_types=1);

namespace VarMapTest;

use VarMap\ArrayVarMap;
use VarMap\Psr7VarMap;
use VarMap\Exception\VariableMissingException;

class Psr7InputMapTest extends BaseTestCase
{
    public function testPSR7VariableMapWorks()
    {
        $cliRequest = new CLIRequest("/?foo=bar", "example.com");
        $varMap = new Psr7VarMap($cliRequest);
        $fooValue = $varMap->get('foo');
        $this->assertEquals($fooValue, $fooValue);
    }
    public function testPSR7VariableMapException()
    {
        $cliRequest = new CLIRequest("/?zot=fot", "example.com");
        $varMap = new Psr7VarMap($cliRequest);
        $this->expectException(VariableMissingException::class);
        $varMap->get('foo');
    }
    public function testArrayInputMapHas()
    {
        $cliRequest = new CLIRequest("/?zot=fot", "example.com");
        $varMap = new Psr7VarMap($cliRequest);

        $this->assertTrue($varMap->has('zot'));
        $this->assertFalse($varMap->has('quux'));
    }

    public function testArrayInputMapGetWithDefault()
    {
        $cliRequest = new CLIRequest("/?zot=fot", "example.com");
        $varMap = new Psr7VarMap($cliRequest);
        $this->assertEquals('fot', $varMap->getWithDefault('zot', null));
        $this->assertNull($varMap->getWithDefault('quux', null));
    }

    public function testArrayInputMapGetNames()
    {
        $cliRequest = new CLIRequest("/?zot=fot", "example.com");
        $varMap = new Psr7VarMap($cliRequest);
        $this->assertEquals(['zot'], $varMap->getNames());
    }
}
