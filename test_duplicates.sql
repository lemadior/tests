CREATE DATABASE IF NOT EXISTS testdb;

USE testdb;

DROP TABLE IF EXISTS products;

CREATE TABLE `test_table` (
    `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL);

INSERT INTO `test_table` (`key`) VALUES
	('prod'),
	('cat'),
	('prod'),
    ('key'),
    ('key');
