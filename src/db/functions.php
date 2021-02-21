<?php
/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  \PDO $pdo
 * @return string[]
 */
function getUniqueFirstLetters(\PDO $pdo)
{
    $query = <<<'SQL'
        SELECT DISTINCT(LEFT (name, 1)) as letter 
        FROM airports
        ORDER BY letter;
    SQL;

    $sth = $pdo->prepare($query);
    $sth->execute();

    $first_letters = $sth->fetchAll(\PDO::FETCH_COLUMN);

    return $first_letters;
}

/**
 *
 *
 *
 * @param PDO $pdo
 * @param array|NULL $filters
 * @return int
 */
function getAirportsCount(\PDO $pdo, array $filters = NULL)
{
    $query = <<<'SQL'
        SELECT count(*) as count
        FROM airports
        JOIN cities on cities.id = airports.city_id
        JOIN states on states.id = cities.state_id
    SQL;

    if (!empty($filters)) {
        $query .= ' WHERE 1';
        foreach ($filters as $filter){
            $query .= ' AND ' . $filter;
        }
    }

    $sth = $pdo->prepare($query);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();

    $result = $sth->fetch();
    return !empty($result) ? $result['count'] : 0;
}
/**
 *
 *
 *
 * @param PDO $pdo
 * @param array|NULL $filters
 * @param string|NULL $sort_by
 * @param int|NULL $limit
 * @param int|NULL $offset
 * @return array
 */
function getAirports(\PDO $pdo, array $filters = NULL, string $sort_by = NULL, int $limit = NULL, int $offset = NULL)
{
    $query = <<<'SQL'
        SELECT airports.id, airports.name, airports.address, airports.code, cities.name as city, states.name as state, timezone 
        FROM airports
        JOIN cities on cities.id = airports.city_id
        JOIN states on states.id = cities.state_id
    SQL;

    if (!empty($filters)) {
        $query .= ' WHERE 1';
        foreach ($filters as $filter){
            $query .= ' AND ' . $filter . '';
        }
    }

    if ($sort_by) {
        $query .= ' ORDER BY ' . $sort_by;
    }

    if ($limit) {
        $query .= ' LIMIT ' . $limit;
    }

    if ($limit && $offset) {
        $query .= ' OFFSET ' . $offset;
    }

    $sth = $pdo->prepare($query);
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute();

    $airports = $sth->fetchAll();

    return $airports;
}


/**
 * @return mixed
 */
function get_url_params()
{
    $urlArr = parse_url($_SERVER['REQUEST_URI']);
    if (empty($urlArr['query'])) {
        return [];
    }
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
 * @param int $count
 * @param int $page
 * @param int $item_pre_page
 * @return array
 */
function get_pagination_info(int $count, int $page, int $item_pre_page)
{
    $last_page = floor($count / $item_pre_page);

    $pagination = [
        'item_pre_page' => $item_pre_page,
        'page' => $page,
        'last_page' => $last_page,
        'first_paginator_item' => 1,
        'last_paginator_item' => $last_page,
        'to_first_page' => false,
        'to_last_page' => false,
        'total' => $count,
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
