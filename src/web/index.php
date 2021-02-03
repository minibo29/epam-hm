<?php
require_once './functions.php';

$airports = require './airports.php';
$url_params = get_url_params();
unset($url_params['page']);

// Filtering
/**
 * Here you need to check $_GET request if it has any filtering
 * and apply filtering by First Airport Name Letter and/or Airport State
 * (see Filtering tasks 1 and 2 below)
 */
if (!empty($url_params['filter_by_first_letter'])) {
    $filter_by_first_letter = $url_params['filter_by_first_letter'];
    $airports = array_filter($airports, function ($airport) use($filter_by_first_letter){
        $filter_by_first_letter = strtolower($filter_by_first_letter);

        return strtolower($airport['name'][0]) === $filter_by_first_letter || strtolower($airport['name'][0]) === $filter_by_first_letter;
    });
}

if (!empty($_GET['filter_by_state'])) {
    $airports = array_filter($airports, function ($airport) {
        $filter_by_state = $_GET['filter_by_state'];

        return strtolower($airport['state']) === strtolower($filter_by_state);
    });
}

// Sorting
/**
 * Here you need to check $_GET request if it has sorting key
 * and apply sorting
 * (see Sorting task below)
 */
$sort_by = !empty($_GET['sort']) ? $_GET['sort'] : 'name';
$airports = sortItems($airports, $sort_by);

// Pagination
/**
 * Here you need to check $_GET request if it has pagination key
 * and apply pagination logic
 * (see Pagination task below)
 */
$pagination_info = get_pagination_info($airports);

$airports = array_slice($airports, ($pagination_info['page'] -1 ) * $pagination_info['item_pre_page'], $pagination_info['item_pre_page']);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Airports</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<main role="main" class="container">

    <h1 class="mt-5">US Airports</h1>

    <!--
        Filtering task #1
        Replace # in HREF attribute so that link follows to the same page with the filter_by_first_letter key
        i.e. /?filter_by_first_letter=A or /?filter_by_first_letter=B

        Make sure, that the logic below also works:
         - when you apply filter_by_first_letter the page should be equal 1
         - when you apply filter_by_first_letter, than filter_by_state (see Filtering task #2) is not reset
           i.e. if you have filter_by_state set you can additionally use filter_by_first_letter
    -->


    <div class="alert alert-dark">
        Filter by first letter:

        <?php foreach (getUniqueFirstLetters(require './airports.php') as $letter): ?>
            <a href="<?= buildUrl(array_merge($url_params, ['filter_by_first_letter' => $letter]))?>"><?= $letter ?></a>
        <?php endforeach; ?>

        <a href="/" class="float-right">Reset all filters</a>
    </div>

    <!--
        Sorting task
        Replace # in HREF so that link follows to the same page with the sort key with the proper sorting value
        i.e. /?sort=name or /?sort=code etc

        Make sure, that the logic below also works:
         - when you apply sorting pagination and filtering are not reset
           i.e. if you already have /?page=2&filter_by_first_letter=A after applying sorting the url should looks like
           /?page=2&filter_by_first_letter=A&sort=name
    -->
    <div class="d-block">
        <div class="float-right">
            Items pre page:
            <a href="<?= buildUrl(array_merge($url_params, ['item_pre_page' => 5]))?>" >5</a>
            <a href="<?= buildUrl(array_merge($url_params, ['item_pre_page' => 10]))?>">10</a>
            <a href="<?= buildUrl(array_merge($url_params, ['item_pre_page' => 20]))?>">20</a>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col"><a href="<?= buildUrl(array_merge($url_params, ['sort' => 'name']))?>">Name</a></th>
            <th scope="col"><a href="<?= buildUrl(array_merge($url_params, ['sort' => 'code']))?>">Code</a></th>
            <th scope="col"><a href="<?= buildUrl(array_merge($url_params, ['sort' => 'state']))?>">State</a></th>
            <th scope="col"><a href="<?= buildUrl(array_merge($url_params, ['sort' => 'city']))?>">City</a></th>
            <th scope="col">Address</th>
            <th scope="col">Timezone</th>
        </tr>
        </thead>
        <tbody>
        <!--
            Filtering task #2
            Replace # in HREF so that link follows to the same page with the filter_by_state key
            i.e. /?filter_by_state=A or /?filter_by_state=B

            Make sure, that the logic below also works:
             - when you apply filter_by_state the page should be equal 1
             - when you apply filter_by_state, than filter_by_first_letter (see Filtering task #1) is not reset
               i.e. if you have filter_by_first_letter set you can additionally use filter_by_state
        -->
        <?php foreach ($airports as $airport): ?>
        <tr>
            <td><?= $airport['name'] ?></td>
            <td><?= $airport['code'] ?></td>
            <td><a href="<?= buildUrl(array_merge($url_params, ['filter_by_state' => $airport['state']]))?>"><?= $airport['state'] ?></a></td>
            <td><?= $airport['city'] ?></td>
            <td><?= $airport['address'] ?></td>
            <td><?= $airport['timezone'] ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!--
        Pagination task
        Replace HTML below so that it shows real pages dependently on number of airports after all filters applied

        Make sure, that the logic below also works:
         - show 5 airports per page
         - use page key (i.e. /?page=1)
         - when you apply pagination - all filters and sorting are not reset
    -->
    <?php if($pagination_info['total'] > $pagination_info['item_pre_page']):?>
        <nav aria-label="Navigation">
            <ul class="pagination justify-content-center">
                <?php if ($pagination_info['to_first_page']):?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= buildUrl(array_merge($url_params, ['page' => 1]))?>"
                           title="To First page"
                        >
                            <<
                        </a>
                    </li>
                <?php endif;?>
                <?php if ($pagination_info['page'] > 1):?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= buildUrl(array_merge($url_params, ['page' => $pagination_info['page'] - 1]))?>"
                           title="Previous page"
                        >
                            <
                        </a>
                    </li>
                <?php endif;?>
                <?php for($paginator_page = $pagination_info['first_paginator_item']; $paginator_page <= $pagination_info['last_paginator_item']; $paginator_page++):?>
                    <li class="page-item <?= $paginator_page == $pagination_info['page'] ? 'active': ''?>">
                        <a class="page-link"
                           href="<?= buildUrl(array_merge($url_params, ['page' => $paginator_page]))?>" >
                            <?= $paginator_page?>
                        </a>
                    </li>
                <?php endfor;?>
                <?php if ($pagination_info['page'] < $pagination_info['last_page']):?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= buildUrl(array_merge($url_params, ['page' => $pagination_info['page'] + 1]))?>"
                           title="Next page"
                        >
                            >
                        </a>
                    </li>
                <?php endif;?>
                <?php if ($pagination_info['to_last_page']):?>
                    <li class="page-item">
                        <a class="page-link"
                           href="<?= buildUrl(array_merge($url_params, ['page' => $pagination_info['last_page']]))?>"
                           title="To Last page"
                        >
                            >>
                        </a>
                    </li>
                <?php endif;?>
            </ul>
        </nav>
    <?php endif;?>
</main>
</html>
