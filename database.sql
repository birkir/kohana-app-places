-- -----------------------------------------------------
-- Eat.is database schema exported from MySQL Workbench
-- -----------------------------------------------------


SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `users` (
  `user_id` INT(11) NOT NULL ,
  `title` VARCHAR(128) NULL ,
  `username` VARCHAR(64) NULL ,
  `email` VARCHAR(64) NULL ,
  `password` VARCHAR(128) NULL ,
  `logins` INT(11) NULL DEFAULT 0 ,
  `last_login` TIMESTAMP NULL ,
  `_user_id` INT(11) NULL DEFAULT 0 ,
  `enabled` TINYINT(1) NULL DEFAULT 1 ,
  `created_at` DATETIME NULL ,
  `removed` TINYINT(1) NULL DEFAULT 0 ,
  PRIMARY KEY (`user_id`) ,
  UNIQUE INDEX `unique_username` (`username` ASC) ,
  UNIQUE INDEX `unique_email` (`email` ASC) ,
  INDEX `fk_users_users1` (`_user_id` ASC, `user_id` ASC) ,
  CONSTRAINT `fk_users_users1`
    FOREIGN KEY (`_user_id` , `user_id` )
    REFERENCES `users` (`_user_id` , `user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `categories` (
  `category_id` INT(11) NOT NULL ,
  `title` VARCHAR(64) NULL ,
  `alias` VARCHAR(64) NULL ,
  `index` INT(11) NULL ,
  `user_id` INT(11) NULL DEFAULT 0 ,
  `created_at` TIMESTAMP NULL ,
  `enabled` TINYINT(1) NULL DEFAULT 1 ,
  `removed` TINYINT(1) NULL DEFAULT 0 ,
  PRIMARY KEY (`category_id`) ,
  INDEX `fk_categories_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_categories_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `food`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `food` (
  `food_id` INT(11) NOT NULL ,
  `title` VARCHAR(64) NULL ,
  `alias` VARCHAR(64) NULL ,
  `user_id` INT(11) NULL ,
  `created_at` TIMESTAMP NULL ,
  `enabled` TINYINT(1) NULL ,
  `removed` TINYINT(1) NULL ,
  PRIMARY KEY (`food_id`) ,
  INDEX `fk_food_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_food_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `places`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `places` (
  `place_id` INT(11) NOT NULL ,
  `title` VARCHAR(128) NULL ,
  `alias` VARCHAR(64) NULL ,
  `website` VARCHAR(128) NULL ,
  `email` VARCHAR(64) NULL ,
  `phone` VARCHAR(16) NULL ,
  `description` TEXT NULL ,
  `street_name` VARCHAR(64) NULL ,
  `street_number` VARCHAR(16) NULL ,
  `zip` SMALLINT(3) NULL ,
  `price_from` INT(5) NULL DEFAULT 0 ,
  `price_to` INT(5) NULL DEFAULT 0 ,
  `latitude` DOUBLE NULL DEFAULT 0 ,
  `longitude` DOUBLE NULL DEFAULT 0 ,
  `user_id` INT(11) NULL DEFAULT 0 ,
  `created_at` TIMESTAMP NULL ,
  `enabled` TINYINT(1) NULL DEFAULT 1 ,
  `removed` TINYINT(1) NULL DEFAULT 0 ,
  PRIMARY KEY (`place_id`) ,
  INDEX `fk_places_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_places_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `hours`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hours` (
  `hour_id` INT(11) NOT NULL ,
  `place_id` INT(11) NULL ,
  `day_of_week` TINYINT(1) NULL ,
  `open` INT(4) NULL ,
  `close` INT(4) NULL ,
  PRIMARY KEY (`hour_id`) ,
  INDEX `fk_hours_places1` (`place_id` ASC) ,
  CONSTRAINT `fk_hours_places1`
    FOREIGN KEY (`place_id` )
    REFERENCES `places` (`place_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `places_categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `places_categories` (
  `place_id` INT(11) NOT NULL ,
  `category_id` INT(11) NOT NULL ,
  PRIMARY KEY (`place_id`, `category_id`) ,
  INDEX `fk_places_categories_categories1` (`category_id` ASC) ,
  INDEX `fk_places_categories_places1` (`place_id` ASC) ,
  CONSTRAINT `fk_places_categories_categories1`
    FOREIGN KEY (`category_id` )
    REFERENCES `categories` (`category_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_places_categories_places1`
    FOREIGN KEY (`place_id` )
    REFERENCES `places` (`place_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `places_food`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `places_food` (
  `place_id` INT(11) NOT NULL ,
  `food_id` INT(11) NOT NULL ,
  PRIMARY KEY (`place_id`, `food_id`) ,
  INDEX `fk_places_food_places1` (`place_id` ASC) ,
  INDEX `fk_places_food_food1` (`food_id` ASC) ,
  CONSTRAINT `fk_places_food_places1`
    FOREIGN KEY (`place_id` )
    REFERENCES `places` (`place_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_places_food_food1`
    FOREIGN KEY (`food_id` )
    REFERENCES `food` (`food_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `rating`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `rating` (
  `rating_id` INT(11) NOT NULL ,
  `place_id` INT(11) NULL ,
  `user_id` INT(11) NULL ,
  `rating` TINYINT(1) NULL ,
  PRIMARY KEY (`rating_id`) ,
  INDEX `fk_rating_places` (`place_id` ASC) ,
  INDEX `fk_rating_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_rating_places`
    FOREIGN KEY (`place_id` )
    REFERENCES `places` (`place_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rating_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `roles` (
  `role_id` INT(11) NOT NULL ,
  `title` VARCHAR(128) NULL ,
  `name` VARCHAR(32) NULL ,
  `description` VARCHAR(255) NULL ,
  PRIMARY KEY (`role_id`) ,
  UNIQUE INDEX `unique_name` (`name` ASC) )
ENGINE = InnoDB DEFAULT CHARSET=utf8;


-- -----------------------------------------------------
-- Table `roles_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `roles_users` (
  `user_id` INT(11) NOT NULL ,
  `role_id` INT(11) NOT NULL ,
  PRIMARY KEY (`user_id`, `role_id`) ,
  INDEX `fk_roles_users_users1` (`user_id` ASC) ,
  INDEX `fk_roles_users_roles1` (`role_id` ASC) ,
  CONSTRAINT `fk_roles_users_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_roles_users_roles1`
    FOREIGN KEY (`role_id` )
    REFERENCES `roles` (`role_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
