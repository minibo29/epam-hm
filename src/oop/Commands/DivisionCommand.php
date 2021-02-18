<?php

namespace src\oop\Commands;

class DivisionCommand implements CommandInterface
{
    /**
     * @inheritdoc
     */
    public function execute(...$args)
    {
        if (2 != sizeof($args)) {
            throw new \InvalidArgumentException('Not enough parameters');
        }

        if (0 == $args[1]) {
            throw new \InvalidArgumentException('Can\'t Divide by 0.');
        }

        return $args[0] / $args[1];
    }
}
