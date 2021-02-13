<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{

    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);

        countArgumentsWrapper(1, 'Second arg', 'Third arg');
    }
}
