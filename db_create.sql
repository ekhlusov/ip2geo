DROP SCHEMA IF EXISTS `geoip_test`; 
CREATE SCHEMA IF NOT EXISTS `geoip_test`;
USE `geoip_test`;

DROP TABLE IF EXISTS geo_location;

CREATE TABLE IF NOT EXISTS `geo_location` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `country` VARCHAR(2) DEFAULT NULL,
    `region` VARCHAR(2) DEFAULT NULL,
    `city` VARCHAR(255) DEFAULT NULL,
    `zip` VARCHAR(10) DEFAULT NULL,
    `latitude` FLOAT DEFAULT NULL COMMENT "Широта",
    `longitude` FLOAT DEFAULT NULL COMMENT "Долгота",
    PRIMARY KEY (`id`),
    INDEX(country, city, latitude, longitude)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS geo_blocks;

CREATE TABLE `geo_blocks` (
  `ip_start` INT(11) UNSIGNED NOT NULL,
  `ip_end` INT(11) UNSIGNED DEFAULT NULL,
  `location_id` INT(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`ip_start`, `ip_end`),
  UNIQUE INDEX(location_id),
  FOREIGN KEY (location_id)
         REFERENCES geo_location(id)
         ON DELETE CASCADE
) DEFAULT CHARSET=utf8;