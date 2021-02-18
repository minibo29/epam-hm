<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SebastianBergmann\ObjectReflector\ObjectReflector;
use src\oop\Calculator;
use src\oop\Commands\CommandInterface;

class CalculatorTest extends TestCase
{
    /**
     * @var Calculator
     */
    private $calc;

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     */
    public function setUp(): void
    {
        $this->calc = new Calculator();
    }

    /**
     * @see https://phpunit.readthedocs.io/en/9.5/test-doubles.html
     *
     * @return MockObject
     */
    public function getCommandMock(): MockObject
    {
        return $this->getMockBuilder(CommandInterface::class)
            ->getMock();
    }

    public function getAttribute($attribute)
    {
        $ObjectReflector = new ObjectReflector;
        $attributes = $ObjectReflector->getAttributes($this->calc);

        return isset($attributes[$attribute]) ? $attributes[$attribute] : null;
    }

    /**
     * TODO: Check whether intents = []
     * TODO: Check whether value = 0.0
     *
     * @see PHPUnit::assertAttributeEquals
     */
    public function testInitialCalcState()
    {

        $this->assertEquals([], $this->getAttribute('intents'));
        $this->assertEquals(0.0, $this->getAttribute('value'));
    }

    /**
     * TODO: Check name exception
     *
     * @covers Calculator::addCommand()
     */
    public function testAddCommandNegative()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calc->addCommand([], new \src\oop\Commands\SumCommand());
    }

    /**
     * TODO: Check whether command is in the commands array
     *
     * @covers Calculator::addCommand()
     */
    public function testAddCommandPositive()
    {
        $this->calc->addCommand('+', new \src\oop\Commands\SumCommand());
        $ObjectReflector = new ObjectReflector;
        $attributes = $ObjectReflector->getAttributes($this->calc);

        $this->assertTrue(array_key_exists('+', $attributes['commands']));
    }

    /**
     * TODO: Check whether intents = []
     * TODO: Check whether value = expected
     *
     * @see PHPUnit :: assertAttributeEquals
     */
    public function testInit()
    {
        $this->calc->init(1);

        $this->assertEquals([], $this->getAttribute('intents'));
        $this->assertEquals(1, $this->getAttribute('value'));
    }

    /**
     * TODO: Check hasCommand exception
     *
     * @see PHPUnit :: dataProvider
     */
    public function testComputeNegative()
    {
        $this->calc->addCommand('+', new \src\oop\Commands\SumCommand());
        $this->assertFalse($this->calc->hasCommand('-'));
    }

    /**
     * TODO: Check whether command and arguments have appeared in the intents array
     *
     * @see PHPUnit :: assertAttributeEquals
     */
    public function testComputePositive()
    {
        $this->calc->addCommand('+', new \src\oop\Commands\SumCommand());
        $this->calc->init(1)
            ->compute('+', 5);

        $this->assertNotEmpty($this->getAttribute('intents'));
    }

    /**
     * TODO: Check that command was executed
     *
     * Mock command`s execute method and check whether it was called at least once with the correct arguments
     *
     * @see https://phpunit.readthedocs.io/en/9.5/test-doubles.html
     *
     * @covers Calculator::getResult()
     */
    public function testGetResultPositive()
    {
        $this->calc->addCommand('+', new \src\oop\Commands\SumCommand());

         $this->calc->init(1)
            ->compute('+', 5)
            ->compute('+', 5);


        return $this->assertEquals(11, $this->calc->getResult());
    }

    /**
     * TODO: Check that command was executed with exception
     *
     * Mock command`s execute method so that it returns exception and check whether it was thrown
     *
     * @see https://phpunit.readthedocs.io/en/9.5/test-doubles.html
     *
     * @covers Calculator::getResult()
     */
    public function testGetResultNegative()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calc->init(1)
            ->compute('-', 5);

        $this->calc->getResult();
    }

    /**
     * TODO: Check whether the last item in the intents array was duplicated
     */
    public function testReplay()
    {
        $this->calc->addCommand('+', new \src\oop\Commands\SumCommand());

        $this->calc->init(1)
            ->compute('+', 5)
            ->compute('+', 5)
            ->replay()
            ->replay()
        ;

        return $this->assertEquals(4, count($this->getAttribute('intents')));

    }

    /**
     * TODO: Check whether the last item was removed from intents array
     */
    public function testUndo()
    {
        $this->calc->addCommand('+', new \src\oop\Commands\SumCommand());

        $this->calc->init(1)
            ->compute('+', 5)
            ->compute('+', 5)
            ->undo()
        ;

        return $this->assertEquals(1, count($this->getAttribute('intents')));
    }

    /**
     * TODO: what difference between tearDown() and tearDownAfterClass()
     *
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     */
    public function tearDown(): void
    {
        unset($this->calc);
    }
}
