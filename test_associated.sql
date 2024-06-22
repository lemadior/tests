CREATE DATABASE IF NOT EXISTS testdb;

USE testdb;

DROP TABLE IF EXISTS products;

CREATE TABLE `products` (
    `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `p_name` VARCHAR(255) NOT NULL);

LOCK TABLES `products` WRITE;

INSERT INTO `products` (`p_name`) VALUES
	('prod1'),
	('prod2'),
	('prod3');

UNLOCK TABLES;

DROP TABLE IF EXISTS categories;

CREATE TABLE `categories` (
    `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `c_name` VARCHAR(255) NOT NULL);

LOCK TABLES `categories` WRITE;

INSERT INTO `categories` (`c_name`) VALUES
	('cat1'),
	('cat2'),
	('cat3');

UNLOCK TABLES;

DROP TABLE IF EXISTS `associations`;

CREATE TABLE `associations` (
    `c_id` INT NOT NULL,
    `p_id` INT NOT NULL,
    FOREIGN KEY (`c_id`) REFERENCES categories(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`p_id`) REFERENCES products(`id`) ON DELETE CASCADE);

LOCK TABLES `associations` WRITE;

INSERT INTO `associations` (`c_id`, `p_id`) VALUES
	(1, 1),
	(1, 2),
	(2, 1),
	(3, 2),
	(3, 3);

UNLOCK TABLES;

# QUERY FOR get associated data

# SELECT categories.c_name, products.p_name
# FROM associations
# JOIN products ON products.id = associations.p_id
# JOIN categories ON categories.id = associations.c_id
# ORDER BY c_name;
