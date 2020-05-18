CREATE TABLE `address_book`.`contact` (
   `contact_id` INT NOT NULL AUTO_INCREMENT ,
   `contact_first_name` VARCHAR(50) NOT NULL ,
   `contact_last_name` VARCHAR(50) NOT NULL ,
   `contact_full_name` VARCHAR(110) NOT NULL ,
   `contact_email` VARCHAR(80) NOT NULL ,
   `contact_street` VARCHAR(150) NOT NULL ,
   `contact_city_id` INT NOT NULL ,
   `contact_zip_code` VARCHAR(11) NOT NULL ,
   PRIMARY KEY (`contact_id`)
 ) ENGINE = InnoDB;

CREATE TABLE `address_book`.`city` (
  `city_id` INT NOT NULL AUTO_INCREMENT ,
  `city_name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`city_id`)
) ENGINE = InnoDB;
