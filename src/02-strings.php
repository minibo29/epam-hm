<?php
/**
 * The $input variable contains text in snake case (i.e. hello_world or this_is_home_task)
 * Transform it into a camel-cased string and return (i.e. helloWorld or thisIsHomeTask)
 * @see http://xahlee.info/comp/camelCase_vs_snake_case.html
 *
 * @param  string  $input
 * @return string
 */
function snakeCaseToCamelCase(string $input)
{
    $string = ucwords($input, "_");
    $string = str_replace('_', '', $string);
    $string = lcfirst($string);

    return $string;
}

/**
 * The $input variable contains multibyte text like 'ФЫВА олдж'
 * Mirror each word individually and return transformed text (i.e. 'АВЫФ ждло')
 * !!! do not change words order
 *
 * @param  string  $input
 * @return string
 */
function mirrorMultibyteString(string $input)
{
    $arrWords = explode(' ', $input);

    $str = '';
    foreach ($arrWords as $word) {
        for ($i = mb_strlen($word,"UTF-8"); $i >= 0; --$i) {
            $str .= mb_substr($word, $i, 1, "UTF-8");
        }

        $str .= ' ';
    }

    return trim($str);
}

/**
 * My friend wants a new band name for her band.
 * She likes bands that use the formula: 'The' + a noun with the first letter capitalized.
 * However, when a noun STARTS and ENDS with the same letter,
 * she likes to repeat the noun twice and connect them together with the first and last letter,
 * combined into one word like so (WITHOUT a 'The' in front):
 * dolphin -> The Dolphin
 * alaska -> Alaskalaska
 * europe -> Europeurope
 * Implement this logic.
 *
 * @param  string  $noun
 * @return string
 */
function getBrandName(string $noun)
{
    $noun = trim(strtolower($noun));

    $firsLetter = mb_substr($noun, 0, 1, "UTF-8");
    $lastLetter = mb_substr($noun, -1, 1, "UTF-8");

    if ($firsLetter == $lastLetter) {
        $brandName = ucfirst($noun) . mb_substr($noun, 1, mb_strlen($noun, "UTF-8"), "UTF-8");
    } else {
        $brandName = 'The ' . ucfirst($noun);
    }

    return $brandName;

}
