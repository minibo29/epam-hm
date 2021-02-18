<?php

use PHPUnit\Framework\TestCase;
use src\oop\Commands\DivisionCommand;

class DivisionCommandTest extends TestCase
{
    /**
     * @var DivisionCommand
     */
    private $command;

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     *
     * @inheritdoc
     */
    public function setUp(): void
    {
        $this->command = new DivisionCommand();
    }

    /**
     * @return array
     */
    public function commandPositiveDataProvider()
    {
        return [
            [15, 5, 3],
            [-4, 2, -2],
            [3, 1, 3],
            [63, 7, 9],
        ];
    }

    /**
     * @dataProvider commandPositiveDataProvider
     */
    public function testCommandPositive($a, $b, $expected)
    {
        $result = $this->command->execute($a, $b);

        $this->assertEquals($expected, $result);
    }

    public function testCommandNegative()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->command->execute(1);
    }

    public function testDivideByZeroNegative()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->command->execute(5, 0);
    }

    /**
     * @see https://phpunit.readthedocs.io/en/9.3/fixtures.html#more-setup-than-teardown
     *
     * @inheritdoc
     */
    public function tearDown(): void
    {
        unset($this->command);
    }
}
