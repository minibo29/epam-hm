<?php
/**
 * TODO
 *  Open web/airports.php file
 *  Go through all airports in a loop and INSERT airports/cities/states to equivalent DB tables
 *  (make sure, that you do not INSERT the same values to the cities and states i.e. name should be unique i.e. before INSERTing check if record exists)
 */

/** @var \PDO $pdo */
require_once './pdo_ini.php';

foreach (require_once('../web/airports.php') as $item) {

    //Import States
    $stateId = importState($pdo, $item);
    //Import Cities
    $cityId = importCity($pdo, $item, $stateId);
    //Import Airports
    $stateId = importAirport($pdo, $item, $cityId);
}


function getEntityByName(\PDO $pdo, $entityTable, $name)
{
    $sth = $pdo->prepare('SELECT id FROM :table WHERE name = :name');
    $sth->setFetchMode(\PDO::FETCH_ASSOC);
    $sth->execute(['table' => $entityTable, 'name' => $name]);

    return $sth->fetch();
}

function importState(\PDO $pdo, $item)
{
    $state = getEntityByName($pdo, 'states', $item['state']);

    // If result is empty - we need to INSERT state
    if (!$state) {
        $sth = $pdo->prepare('INSERT INTO states (name, timezone) VALUES (:name, :timezone)');
        $sth->execute([
            'name' => $item['state'],
            'timezone' => $item['timezone'],
        ]);

        // We will use this variable to INSERT City
        $stateId = $pdo->lastInsertId();
    } else {
        // We will use this variable to INSERT City
        $stateId = $state['id'];
    }

    return $stateId;
}


function importCity(\PDO $pdo, $item, $stateId = null)
{
    $city = getEntityByName($pdo, 'cities', $item['state']);

    // If result is empty - we need to INSERT city
    if (!$city) {
        if (!$stateId) {
            if(!($state = getEntityByName($pdo, 'states', $item['state']))){
                return null;
            }
            $stateId = $state['id'];
        }


        $sth = $pdo->prepare('INSERT INTO cities (name, state_id) VALUES (:name)');
        $sth->execute([
            'name' => $item['city'],
            'state_id' => $stateId
        ]);

        // We will use this variable to INSERT airport
        $cityId = $pdo->lastInsertId();
    } else {
        // We will use this variable to INSERT airport
        $cityId = $city['id'];
    }

    return $cityId;
}

/**
 * Imports Airport
 *
 * @param \PDO $pdo
 * @param $item
 * @param null $cityId
 * @return mixed|string|null
 */
function importAirport(\PDO $pdo, $item, $cityId = null)
{
    $airport = getEntityByName($pdo, 'airports', $item['state']);

    // If result is empty - we need to INSERT city
    if (!$airport) {
        if (!$cityId) {
            if(!($city = getEntityByName($pdo, 'cities', $item['state']))){
                return null;
            }
            $cityId = $city['id'];
        }

        $sth = $pdo->prepare('INSERT INTO airports (name, code, address, city_id) 
          VALUES (:name, :code, :address, :city_id)');
        $sth->execute([
            'name' => $item['name'],
            'code' => $item['code'],
            'address' => $item['address'],
            'city_id' => $cityId,
        ]);

        // We will use this variable to INSERT airport
        $airport = $pdo->lastInsertId();
    } else {
        // We will use this variable to INSERT airport
        $airport = $airport['id'];
    }

    return $airport;
}

