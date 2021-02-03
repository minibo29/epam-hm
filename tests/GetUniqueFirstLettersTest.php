<?php

use PHPUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($arr, $expected)
    {
        $this->assertEquals($expected, getUniqueFirstLetters($arr));
    }

    public function positiveDataProvider()
    {
        return [
            [
                [
                    ['name' => 'America'],
                    ['name' => 'Asia'],
                    ['name' => 'Europe'],
                ],
                ['A', 'E']
            ],
            [
                [
                    ['name' => 'Scorpions'],
                    ['name' => 'Rammstein'],
                    ['name' => 'Queen'],
                    ['name' => 'Kiss'],
                ],
                ['K', 'Q', 'R', 'S']
            ],

        ];
    }
}
