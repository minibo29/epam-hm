<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{

    public function testPositive($expected, ...$arg)
    {
        $this->assertEquals($expected, countArguments(...$arg));
    }

    public function positiveDataProvider()
    {
        return [
            [
                [
                    'argument_count'  => 2,
                    'argument_values' => [
                        'First arg',
                        'Second arg',
                    ]
                ],
                'First arg', 'Second arg'
            ],
            [
                [
                    'argument_count'  => 1,
                    'argument_values' => [
                        'First arg',
                    ]
                ],
                'First arg'
            ],
            [
                [
                    'argument_count'  => 2,
                    'argument_values' => [
                        'First arg',
                        'Second arg',
                        'Third arg',
                    ]
                ],
                'First arg', 'Second arg', 'Third arg'
            ],
        ];
    }
}
