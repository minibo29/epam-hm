<?php
/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports)
{
    // put your logic here
    $first_letters = [];
    foreach ($airports as $airport) {
        $first_latter = strtoupper($airport['name'][0]);
        if (!in_array($first_latter, $first_letters)) {
            $first_letters[] = $first_latter;
        }
    }
    sort($first_letters);
    return $first_letters;
}

/**
 * @param array $items
 * @param string $sort_by
 *
 * @return array
 */
function sortItems(array $items, string $sort_by)
{
    usort($items, function ($item_a, $item_b) use ($sort_by) {
        if (!empty($item_a[$sort_by])) {
            return $item_a[$sort_by] <=> $item_b[$sort_by];
        }

        return 0;
    });

    return $items;
}

/**
 * @return mixed
 */
function get_url_params()
{
    $urlArr = parse_url($_SERVER['REQUEST_URI']);
    parse_str($urlArr['query'], $output);
    return $output;
}

/**
 * @param $params
 * @return string
 */
function buildUrl($params)
{
    return '?' . http_build_query($params);
}

/**
 * @param array $items
 * @return array
 */
function get_pagination_info(array $items)
{
    $item_pre_page = !empty($_GET['item_pre_page']) ? $_GET['item_pre_page'] : 5;
//    $page =  !empty($_GET['page']) ? $_GET['page'] : 1;
//    $airports = array_slice($items, ($page -1 ) * $item_pre_page, $item_pre_page);
    $last_page = floor(count($items) / $item_pre_page);


    $pagination = [
        'item_pre_page' => $item_pre_page,
        'page' => !empty($_GET['page']) ? $_GET['page'] : 1,
        'last_page' => $last_page,
        'first_paginator_item' => 1,
        'last_paginator_item' => $last_page,
        'to_first_page' => false,
        'to_last_page' => false,
        'total' => count($items),
    ];

    if ($last_page > $item_pre_page) {
        if (($pagination['page'] - floor($item_pre_page / 2)) > 0) {
            $pagination['to_first_page'] = true;
        }
        if (($pagination['page'] + floor($item_pre_page / 2)) < $last_page) {
            $pagination['to_last_page'] = true;
        }

        if ($pagination['to_first_page'] && $pagination['to_last_page']) {
            $pagination['first_paginator_item'] = $pagination['page'] - floor($item_pre_page / 2);
            $pagination['last_paginator_item'] = $pagination['page'] + floor($item_pre_page / 2);
        } elseif ($pagination['to_first_page'] && !$pagination['to_last_page']) {
            $pagination['first_paginator_item'] = $last_page - $item_pre_page - 1;
        } elseif (!$pagination['to_first_page'] && $pagination['to_last_page']) {
            $pagination['first_paginator_item'] = 1;
            $pagination['last_paginator_item'] = $pagination['first_paginator_item'] + $item_pre_page - 1;
        }
    }


    return $pagination;
}
