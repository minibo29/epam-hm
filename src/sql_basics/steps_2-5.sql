CREATE SCHEMA IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE IF NOT EXISTS `blog`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `active` SMALLINT(1) NOT NULL DEFAULT 1,
  `createAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE);

CREATE TABLE IF NOT EXISTS `blog`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));

  CREATE TABLE IF NOT EXISTS `blog`.`user_roles` (
  `user_id` INT NOT NULL,
  `role_id` INT NOT NULL REFERENCES `blog`.`roles` (`id`),
  FOREIGN KEY (`user_id`)
        REFERENCES `blog`.`users`(`id`)
        ON DELETE CASCADE,
  FOREIGN KEY (`role_id`)
        REFERENCES `blog`.`roles`(`id`)
        ON DELETE CASCADE
  );

CREATE TABLE IF NOT EXISTS `blog`.`posts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `text` LONGTEXT NOT NULL,
  `image` VARCHAR(255) NULL,
  `autor_id` INT NULL ,
  `active` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 1,
  `reviewed` SMALLINT(1) UNSIGNED NOT NULL DEFAULT 0,
  `createAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updateAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`autor_id`)
        REFERENCES `blog`.`users`(`id`)
        ON DELETE SET NULL
  );


INSERT INTO `blog`.`users` (`first_name`, `last_name`, `email`, `password`, `active`)
  VALUES
	('Tom', 'Cuper', 'tom_cuper@gnail.com', '$2y$12$lLbXnm1rjIKzZuAHUEhLE.6OzBnxbE8U3Gu/G6Hp1w6VTRYkVHArK ', '1'),
	('Ervin', 'Howell', 'shanna@melissa.tv', '$2y$12$lLbXnm1rjIKzZuAHUEhLE.6OzBnxbE8U3Gu/G6Hp1w6VTRYkVHArK ', '1'),
	('Clementine', 'Bauch', 'clementine@gnail.com', '$2y$12$lLbXnm1rjIKzZuAHUEhLE.6OzBnxbE8U3Gu/G6Hp1w6VTRYkVHArK ', '0'),
	('Patricia', 'Cuper', 'ulianne.OConner@kory.org', '$2y$12$lLbXnm1rjIKzZuAHUEhLE.6OzBnxbE8U3Gu/G6Hp1w6VTRYkVHArK ', '1'),
	('Chelsey', 'Dietrich', 'Lucio_Hettinger@annie.ca', '$2y$12$lLbXnm1rjIKzZuAHUEhLE.6OzBnxbE8U3Gu/G6Hp1w6VTRYkVHArK ', '1');


INSERT INTO `blog`.`roles` (`name`, `title`)
  VALUES
	('admin', 'Admin'),
	('autor', 'Aautor'),
	('corespondent', 'Corespondent');


INSERT INTO `blog`.`user_roles` (`user_id`, `role_id`)
  VALUES
	('1', '1'),
	('2', '2'),
	('4', '2'),
	('4', '3');


INSERT INTO `blog`.`posts` (`title`, `text`, `image`, `autor_id`, `active`, `reviewed`)
  VALUES
	(
		"Tunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto",
		"https://cdn.searchenginejournal.com/wp-content/uploads/2019/08/c573bf41-6a7c-4927-845c-4ca0260aad6b-760x400.jpeg",
        "1",
        "1",
        "1"
    ),
	(
		"Tunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto",
		"https://cdn.searchenginejournal.com/wp-content/uploads/2019/08/c573bf41-6a7c-4927-845c-4ca0260aad6b-760x400.jpeg",
        "1",
        "0",
        "1"
    ),
	(
		"Tunt aut facere repellat provident occaecati excepturi optio reprehenderit",
        "quia et suscipit\nsuscipit recusandae consequuntur expedita et cum\nreprehenderit molestiae ut ut quas totam\nnostrum rerum est autem sunt rem eveniet architecto",
		"https://cdn.searchenginejournal.com/wp-content/uploads/2019/08/c573bf41-6a7c-4927-845c-4ca0260aad6b-760x400.jpeg",
        "1",
        "1",
        "0"
    ),
	(
		"qui est esse",
        "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla",
		"https://cdn.searchenginejournal.com/wp-content/uploads/2019/08/c573bf41-6a7c-4927-845c-4ca0260aad6b-760x400.jpeg",
        "2",
        "1",
        "1"
    ),
	(
		"qui est esse",
        "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla",
		"https://cdn.searchenginejournal.com/wp-content/uploads/2019/08/c573bf41-6a7c-4927-845c-4ca0260aad6b-760x400.jpeg",
        "2",
        "1",
        "1"
    ),
	(
		"qui est esse",
        "est rerum tempore vitae\nsequi sint nihil reprehenderit dolor beatae ea dolores neque\nfugiat blanditiis voluptate porro vel nihil molestiae ut reiciendis\nqui aperiam non debitis possimus qui neque nisi nulla",
		"https://cdn.searchenginejournal.com/wp-content/uploads/2019/08/c573bf41-6a7c-4927-845c-4ca0260aad6b-760x400.jpeg",
        "2",
        "1",
        "1"
    ),
	(
		"ea molestias quasi exercitationem repellat qui ipsa sit aut",
        "et iusto sed quo iure\nvoluptatem occaecati omnis eligendi aut ad\nvoluptatem doloribus vel accusantium quis pariatur\nmolestiae porro eius odio et labore et velit aut",
		"https://cdn.searchenginejournal.com/wp-content/uploads/2019/08/c573bf41-6a7c-4927-845c-4ca0260aad6b-760x400.jpeg",
        "2",
        "0",
        "0"
    );


