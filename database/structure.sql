-- TODO manage update/delete events
-- MySQL Script generated by MySQL Workbench
-- Sat Apr  3 15:16:59 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering
SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS,
  UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS,
  FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE,
  SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
-- -----------------------------------------------------
-- Schema framboises
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `framboises`;
-- -----------------------------------------------------
-- Schema framboises
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `framboises` DEFAULT CHARACTER SET utf8;
USE `framboises`;
-- -----------------------------------------------------
-- Table `framboises`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`users`;
CREATE TABLE IF NOT EXISTS `framboises`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uniqueUsername` (`username` ASC) INVISIBLE,
  UNIQUE INDEX `uniqueEmail` (`email` ASC) VISIBLE
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`roles`;
CREATE TABLE IF NOT EXISTS `framboises`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uniqueRole` (`name` ASC) VISIBLE
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`openings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`openings`;
CREATE TABLE IF NOT EXISTS `framboises`.`openings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `start` TIMESTAMP NOT NULL,
  `end` TIMESTAMP NOT NULL,
  `description` TEXT NULL,
  `places` TINYINT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`products`;
CREATE TABLE IF NOT EXISTS `framboises`.`products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(3, 2) NOT NULL,
  `unit` VARCHAR(45) NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uniqueProduct` (`name` ASC) VISIBLE
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`types`;
CREATE TABLE IF NOT EXISTS `framboises`.`types` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uniqueType` (`name` ASC) VISIBLE
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`recipes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`recipes`;
CREATE TABLE IF NOT EXISTS `framboises`.`recipes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  `portions` DECIMAL(3, 2) NOT NULL,
  `preparation` TIME NOT NULL,
  `cooking` TIME NOT NULL,
  `rest` TIME NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uniqueRecipe` (`name` ASC) VISIBLE
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`images`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`images`;
CREATE TABLE IF NOT EXISTS `framboises`.`images` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(255) NOT NULL,
  `products_id` INT NOT NULL,
  `recipes_id` INT NOT NULL,
  `order` TINYINT NULL,
  PRIMARY KEY (`id`, `products_id`, `recipes_id`),
  UNIQUE INDEX `uniqueImage` (`path` ASC) VISIBLE,
  INDEX `fk_images_products1_idx` (`products_id` ASC) VISIBLE,
  INDEX `fk_images_recipes1_idx` (`recipes_id` ASC) VISIBLE,
  CONSTRAINT `fk_images_products1` FOREIGN KEY (`products_id`) REFERENCES `framboises`.`products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_images_recipes1` FOREIGN KEY (`recipes_id`) REFERENCES `framboises`.`recipes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`steps`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`steps`;
CREATE TABLE IF NOT EXISTS `framboises`.`steps` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `number` TINYINT NOT NULL,
  `instruction` VARCHAR(255) NOT NULL,
  `recipes_id` INT NOT NULL,
  PRIMARY KEY (`id`, `recipes_id`),
  INDEX `fk_steps_recipes1_idx` (`recipes_id` ASC) VISIBLE,
  CONSTRAINT `fk_steps_recipes1` FOREIGN KEY (`recipes_id`) REFERENCES `framboises`.`recipes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`ingredients`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`ingredients`;
CREATE TABLE IF NOT EXISTS `framboises`.`ingredients` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uniqueIngredient` (`name` ASC) VISIBLE
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`users_possesses_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`users_possesses_roles`;
CREATE TABLE IF NOT EXISTS `framboises`.`users_possesses_roles` (
  `users_id` INT NOT NULL,
  `roles_id` INT NOT NULL,
  PRIMARY KEY (`users_id`, `roles_id`),
  INDEX `fk_users_has_roles_roles1_idx` (`roles_id` ASC) VISIBLE,
  INDEX `fk_users_has_roles_users_idx` (`users_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_has_roles_users` FOREIGN KEY (`users_id`) REFERENCES `framboises`.`users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_roles_roles1` FOREIGN KEY (`roles_id`) REFERENCES `framboises`.`roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`users_reserves_openings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`users_reserves_openings`;
CREATE TABLE IF NOT EXISTS `framboises`.`users_reserves_openings` (
  `users_id` INT NOT NULL,
  `openings_id` INT NOT NULL,
  `name` VARCHAR(60) NOT NULL,
  `quantity` TINYINT NOT NULL,
  PRIMARY KEY (`users_id`, `openings_id`),
  INDEX `fk_users_has_openings_openings1_idx` (`openings_id` ASC) VISIBLE,
  INDEX `fk_users_has_openings_users1_idx` (`users_id` ASC) VISIBLE,
  UNIQUE INDEX `uniqueReservation` (`openings_id` ASC, `name` ASC) VISIBLE,
  CONSTRAINT `fk_users_has_openings_users1` FOREIGN KEY (`users_id`) REFERENCES `framboises`.`users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_openings_openings1` FOREIGN KEY (`openings_id`) REFERENCES `framboises`.`openings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`openings_possesses_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`openings_possesses_products`;
CREATE TABLE IF NOT EXISTS `framboises`.`openings_possesses_products` (
  `openings_id` INT NOT NULL,
  `products_id` INT NOT NULL,
  PRIMARY KEY (`openings_id`, `products_id`),
  INDEX `fk_openings_has_products_products1_idx` (`products_id` ASC) VISIBLE,
  INDEX `fk_openings_has_products_openings1_idx` (`openings_id` ASC) VISIBLE,
  CONSTRAINT `fk_openings_has_products_openings1` FOREIGN KEY (`openings_id`) REFERENCES `framboises`.`openings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_openings_has_products_products1` FOREIGN KEY (`products_id`) REFERENCES `framboises`.`products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`types_defines_products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`types_defines_products`;
CREATE TABLE IF NOT EXISTS `framboises`.`types_defines_products` (
  `types_id` INT NOT NULL,
  `products_id` INT NOT NULL,
  PRIMARY KEY (`types_id`, `products_id`),
  INDEX `fk_types_has_products_products1_idx` (`products_id` ASC) VISIBLE,
  INDEX `fk_types_has_products_types1_idx` (`types_id` ASC) VISIBLE,
  CONSTRAINT `fk_types_has_products_types1` FOREIGN KEY (`types_id`) REFERENCES `framboises`.`types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_types_has_products_products1` FOREIGN KEY (`products_id`) REFERENCES `framboises`.`products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `framboises`.`recipes_requires_ingredients`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `framboises`.`recipes_requires_ingredients`;
CREATE TABLE IF NOT EXISTS `framboises`.`recipes_requires_ingredients` (
  `recipes_id` INT NOT NULL,
  `ingredients_id` INT NOT NULL,
  `amount` DECIMAL(6, 2) NOT NULL,
  `unit` VARCHAR(60) NULL,
  PRIMARY KEY (`recipes_id`, `ingredients_id`),
  INDEX `fk_recipes_has_ingredients_ingredients1_idx` (`ingredients_id` ASC) VISIBLE,
  INDEX `fk_recipes_has_ingredients_recipes1_idx` (`recipes_id` ASC) VISIBLE,
  CONSTRAINT `fk_recipes_has_ingredients_recipes1` FOREIGN KEY (`recipes_id`) REFERENCES `framboises`.`recipes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_recipes_has_ingredients_ingredients1` FOREIGN KEY (`ingredients_id`) REFERENCES `framboises`.`ingredients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;