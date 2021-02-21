<?php
/**
 * TODO
 *  Write DPO statements to create following tables:
 *
 *  # airports
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 *   - code (varchar)
 *   - city_id (relation to the cities table)
 *   - state_id (relation to the states table)
 *   - address (varchar)
 *   - timezone (varchar)
 *
 *  # cities
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 *
 *  # states
 *   - id (unsigned int, autoincrement)
 *   - name (varchar)
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** @var \PDO $pdo */
require_once './pdo_ini.php';

// States
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `states` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
    `timezone` VARCHAR(50) NOT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`id`)
)
;
SQL;
$pdo->exec($sql);


// cities
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `cities` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`state_id` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`state_id`)
        REFERENCES home_task.`states`(`id`)
);
SQL;
$pdo->exec($sql);

// Airports
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `airports` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`code` VARCHAR(50) NOT NULL,
	`address` VARCHAR(255) NOT NULL,
    `city_id` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`city_id`)
        REFERENCES home_task.`cities`(`id`)
);
SQL;
$pdo->exec($sql);
