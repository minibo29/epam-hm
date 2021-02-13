<?php

use PHPUnit\Framework\TestCase;

class GetBrandNameTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, getBrandName($input));
    }

    public function positiveDataProvider()
    {
        return [
            ['dolphin', 'The Dolphin'],
            ['dolphIn', 'The Dolphin'],
            ['DolphiN', 'The Dolphin'],
            ['alaska', 'Alaskalaska'],
            ['Alaska', 'Alaskalaska'],
            [' Alaska', 'Alaskalaska'],
            ['europe', 'Europeurope'],
            ['europE', 'Europeurope'],
            ['php', 'Phphp'],
            ['the', 'The The'],
        ];
    }
}
