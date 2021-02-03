<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{

    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        countArgumentsWrapper('First arg', 'Second arg', 'Third arg');
    }
}
