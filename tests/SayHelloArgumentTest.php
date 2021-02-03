<?php

use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($arg, $expected)
    {
        $this->assertEquals($expected, sayHelloArgument($arg));
    }

    public function positiveDataProvider()
    {
        return [
            [25, 'Hello 25'],
            ['Bob', 'Hello Bob'],
            [false, 'Hello '],
            [true, 'Hello 1'],
        ];
    }
}
