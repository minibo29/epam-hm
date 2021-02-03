<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($expected, ...$args)
    {
        $this->assertEquals($expected, countArguments(...$args));
    }

    public function positiveDataProvider()
    {
        return [
            [
                [
                    'argument_count' => 2,
                    'argument_values' => [
                        'First arg',
                        'Second arg',
                    ]
                ],
                'First arg', 'Second arg'
            ],
            [
                [
                    'argument_count' => 1,
                    'argument_values' => [
                        'First arg',
                    ]
                ],
                'First arg'
            ],
            [
                [
                    'argument_count' => 3,
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
