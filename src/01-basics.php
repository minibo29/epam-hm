<?php
/**
 * The $minute variable contains a number from 0 to 59 (i.e. 10 or 25 or 60 etc).
 * Determine in which quarter of an hour the number falls.
 * Return one of the values: "first", "second", "third" and "fourth".
 * Throw InvalidArgumentException if $minute is negative of greater than 60.
 * @see https://www.php.net/manual/en/class.invalidargumentexception.php
 *
 * @param  int  $minute
 * @return string
 * @throws InvalidArgumentException
 */
function getMinuteQuarter(int $minute)
{
    if ($minute < 0 && $minute > 59) {
        throw new InvalidArgumentException('getMinuteQuarter function only accepts integer between 0 and 59. Input was: ' . $minute);
    }

    if (0 === $minute) {
        $quarter = 'fourth';
    } elseif ($minute < 16) {
        $quarter = 'first';
    } elseif ($minute < 31) {
        $quarter = 'second';
    } elseif ($minute > 30 && $minute < 46) {
        $quarter = 'third';
    } else {
        $quarter = 'fourth';
    }

//    switch (intval($minute/15)) {
//        case '0':
//            $quarter = 'first';
//            break;
//        case '1':
//            $quarter = 'second';
//            break;
//        case '2':
//            $quarter = 'third';
//            break;
//        case '3':
//            $quarter = 'fourth';
//            break;
//        default:
//            $quarter = false;
//    }

    return $quarter;
}

/**
 * The $year variable contains a year (i.e. 1995 or 2020 etc).
 * Return true if the year is Leap or false otherwise.
 * Throw InvalidArgumentException if $year is lower than 1900.
 * @see https://en.wikipedia.org/wiki/Leap_year
 * @see https://www.php.net/manual/en/class.invalidargumentexception.php
 *
 * @param  int  $year
 * @return boolean
 * @throws InvalidArgumentException
 */
function isLeapYear(int $year)
{
    if ($year < 1900) {
        throw new InvalidArgumentException('isLeapYear function only accepts the Year 1900 or more. Input was: ' . $year);
    }

    return !($year%2);
}

/**
 * The $input variable contains a string of six digits (like '123456' or '385934').
 * Return true if the sum of the first three digits is equal with the sum of last three ones
 * (i.e. in first case 1+2+3 not equal with 4+5+6 - need to return false).
 * Throw InvalidArgumentException if $input contains more or less than 6 digits.
 * @see https://www.php.net/manual/en/class.invalidargumentexception.php
 *
 * @param  string  $input
 * @return boolean
 * @throws InvalidArgumentException
 */
function isSumEqual(string $input)
{
    if (!is_numeric($input)) {
        throw new InvalidArgumentException('isSumEqual function only accepts integers. Input was: '. $input);
    }
    if (strlen($input) < 6) {
        throw new InvalidArgumentException('Numeric Length should be 6 like 123456. Input was: '. $input);
    }
    $num1 = $input[0] + $input[1] + $input[2];
    $num2 = $input[3] + $input[4] + $input[5];

    return $num1 === $num2;
}
