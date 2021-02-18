<?php
use src\oop\Calculator;
use src\oop\Commands\DivisionCommand;
use src\oop\Commands\ExponentiationCommand;
use src\oop\Commands\MultiplicationCommand;
use src\oop\Commands\SubCommand;
use src\oop\Commands\SumCommand;

$calc = new Calculator();
$calc->addCommand('+', new SumCommand());
$calc->addCommand('-', new SubCommand());
$calc->addCommand('*', new MultiplicationCommand());
$calc->addCommand('/', new DivisionCommand());
$calc->addCommand('^', new ExponentiationCommand());

// You can use any operation for computing
// will output 2
echo $calc->init(1)
    ->compute('+', 1)
    ->getResult();

echo PHP_EOL;

// Multiply operations
// will output 10
echo $calc->init(15)
    ->compute('+', 5)
    ->compute('-', 10)
    ->getResult();

echo PHP_EOL;

// should output 4
echo $calc->init(1)
    ->compute('+', 1)
    ->replay()
    ->replay()
    ->getResult();

echo PHP_EOL;

// should output 1
echo $calc->init(1)
    ->compute('+', 5)
    ->compute('+', 5)
    ->undo()
    ->undo()
    ->getResult();

echo PHP_EOL;


// should output 24
echo $calc->init(1)
    ->compute('+', 5)
    ->compute('*', 2)
    ->replay()
    ->getResult();

echo PHP_EOL;


// should output 1
echo $calc->init(1)
    ->compute('*', 5)
    ->compute('/', 5)
    ->getResult();

echo PHP_EOL;


// should output 16
echo $calc->init(1)
    ->compute('+', 1)
    ->compute('^', 4)
    ->getResult();

echo PHP_EOL;

