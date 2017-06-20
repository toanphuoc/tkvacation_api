--RewriteEngine On
--RewriteCond %{REQUEST_FILENAME} !-f
--RewriteCond %{REQUEST_FILENAME} !-d
--RewriteRule . index.php [L]

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchTour`(in argkey varchar(45), in argDestinationId int, in argPeriodMin int , in argPeriodMax int , in argPriceMin int, in argPriceMax int, argLimit int, argOffset int)
BEGIN
  select * from tours where 
    case when argKey is not null then upper(name) LIKE CONCAT('%', upper(argkey) , '%') else true end 
    and  case when argDestinationId is not null then destination_id = argDestinationId else true end 
    and case when argPeriodMin is not null then period >= argPeriodMin else true end 
    and case when argPeriodMax is not null then period <= argPeriodMax else true end 
    and case when argPriceMin is not null then price >= argPriceMin else true end 
    and case when argPriceMax is not null then price <= argPriceMax else true end 
    order by date_created desc 
    limit argLimit offset argOffset;
END

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTotalSearchTour`(in argkey varchar(45), in argDestinationId int, in argPeriodMin int , in argPeriodMax int , in argPriceMin int, in argPriceMax int)
BEGIN
  select * from tours where 
    case when argKey is not null then upper(name) LIKE CONCAT('%', upper(argkey) , '%') else true end 
    and  case when argDestinationId is not null then destination_id = argDestinationId else true end 
    and case when argPeriodMin is not null then period >= argPeriodMin else true end 
    and case when argPeriodMax is not null then period <= argPeriodMax else true end 
    and case when argPriceMin is not null then price >= argPriceMin else true end 
    and case when argPriceMax is not null then price <= argPriceMax else true end 
    order by date_created desc;
END


CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `number` varchar(45) NOT NULL,
  `email` varchar(256) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `tkvacation`.`contact` 
ADD COLUMN `is_read` BIT(1) NULL DEFAULT false AFTER `message`;


CREATE TABLE `tkvacation`.`customize_tour` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  `email` VARCHAR(100) NULL,
  `phone_number` VARCHAR(45) NULL,
  `nationality` VARCHAR(45) NULL,
  `destination` VARCHAR(45) NULL,
  `estimate_date_start` DATETIME NULL,
  `estimate_duration` INT(11) NULL,
  `ideas` TEXT NULL,
  PRIMARY KEY (`id`));


SELECT * FROM tkvacation.customize_tour;CREATE TABLE `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tour_id` int(11) NOT NULL,
  `start_date` varchar(100) DEFAULT NULL,
  `number_of_people` int(11) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`id`),
  KEY `FK_BOOKING_TOUR_idx` (`tour_id`),
  CONSTRAINT `FK_BOOKING_TOUR` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tkvacation`.`booking` 
ADD COLUMN `is_check` BIT(1) NULL DEFAULT false AFTER `note`;




