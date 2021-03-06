-- MySQL Script generated by MySQL Workbench
-- Wed Jun  7 16:44:46 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema webshop
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema webshop
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `webshop` DEFAULT CHARACTER SET utf8 ;
USE `webshop` ;

-- -----------------------------------------------------
-- Table `webshop`.`Language`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Language` (
  `idLanguage` VARCHAR(5) NOT NULL,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`idLanguage`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`User` (
  `idUser` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idLanguage` VARCHAR(5) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `emailAddress` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `type` SET('user', 'admin') NULL,
  `address` VARCHAR(150) NULL,
  `postalCode` VARCHAR(7) NULL,
  `city` VARCHAR(50) NULL,
  `phoneNumber` VARCHAR(15) NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idUser`),
  INDEX `fk_User_Language1_idx` (`idLanguage` ASC),
  UNIQUE INDEX `emailAddress_UNIQUE` (`emailAddress` ASC),
  CONSTRAINT `fk_User_Language1`
    FOREIGN KEY (`idLanguage`)
    REFERENCES `webshop`.`Language` (`idLanguage`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Translation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Translation` (
  `idTranslation` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `translation` TEXT NULL,
  `idLanguage` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`idTranslation`),
  INDEX `fk_Translation_Language1_idx` (`idLanguage` ASC),
  CONSTRAINT `fk_Translation_Language1`
    FOREIGN KEY (`idLanguage`)
    REFERENCES `webshop`.`Language` (`idLanguage`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Product`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Product` (
  `idProduct` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `brand` VARCHAR(45) NULL,
  `name` INT UNSIGNED NOT NULL,
  `description` INT UNSIGNED NULL,
  `combinationDiscount` TINYINT(1) NOT NULL DEFAULT 0,
  `insertDate` DATETIME NOT NULL,
  `URI` VARCHAR(45) NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idProduct`),
  UNIQUE INDEX `URI_UNIQUE` (`URI` ASC),
  INDEX `fk_Product_Translation1_idx` (`name` ASC),
  INDEX `fk_Product_Translation2_idx` (`description` ASC),
  CONSTRAINT `fk_Product_Translation1`
    FOREIGN KEY (`name`)
    REFERENCES `webshop`.`Translation` (`idTranslation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Product_Translation2`
    FOREIGN KEY (`description`)
    REFERENCES `webshop`.`Translation` (`idTranslation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Search`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Search` (
  `idSearch` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idUser` INT UNSIGNED NULL,
  `query` VARCHAR(255) NOT NULL,
  `time` DATETIME NOT NULL,
  PRIMARY KEY (`idSearch`),
  INDEX `fk_Search_User1_idx` (`idUser` ASC),
  CONSTRAINT `fk_Search_User1`
    FOREIGN KEY (`idUser`)
    REFERENCES `webshop`.`User` (`idUser`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Variation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Variation` (
  `idVariation` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idProduct` INT UNSIGNED NOT NULL,
  `price` DECIMAL(6,2) NOT NULL,
  `stock` INT UNSIGNED NOT NULL,
  `tax` DECIMAL(6,2) NULL,
  PRIMARY KEY (`idVariation`),
  INDEX `fk_Variation_Product1_idx` (`idProduct` ASC),
  CONSTRAINT `fk_Variation_Product1`
    FOREIGN KEY (`idProduct`)
    REFERENCES `webshop`.`Product` (`idProduct`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Category` (
  `idCategory` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idParentCategory` INT UNSIGNED NULL,
  `name` INT UNSIGNED NOT NULL,
  `position` INT NOT NULL,
  `active` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idCategory`),
  INDEX `fk_Category_Category1_idx` (`idParentCategory` ASC),
  INDEX `fk_Category_Translation1_idx` (`name` ASC),
  CONSTRAINT `fk_Category_Category1`
    FOREIGN KEY (`idParentCategory`)
    REFERENCES `webshop`.`Category` (`idCategory`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Category_Translation1`
    FOREIGN KEY (`name`)
    REFERENCES `webshop`.`Translation` (`idTranslation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Feature`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Feature` (
  `idFeature` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idFeature`),
  INDEX `fk_Feature_Translation1_idx` (`name` ASC),
  CONSTRAINT `fk_Feature_Translation1`
    FOREIGN KEY (`name`)
    REFERENCES `webshop`.`Translation` (`idTranslation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`FeatureValue`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`FeatureValue` (
  `idFeatureValue` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idFeature` INT UNSIGNED NOT NULL,
  `value` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idFeatureValue`),
  INDEX `fk_FeatureValue_Feature1_idx` (`idFeature` ASC),
  CONSTRAINT `fk_FeatureValue_Feature1`
    FOREIGN KEY (`idFeature`)
    REFERENCES `webshop`.`Feature` (`idFeature`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Image`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Image` (
  `idImage` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idOriginalImage` INT UNSIGNED NOT NULL,
  `name` INT UNSIGNED NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `size` SET('original', 'thumbnail') NOT NULL DEFAULT 'original',
  PRIMARY KEY (`idImage`),
  INDEX `fk_Image_Image1_idx` (`idOriginalImage` ASC),
  INDEX `fk_Image_Translation1_idx` (`name` ASC),
  CONSTRAINT `fk_Image_Image1`
    FOREIGN KEY (`idOriginalImage`)
    REFERENCES `webshop`.`Image` (`idImage`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Image_Translation1`
    FOREIGN KEY (`name`)
    REFERENCES `webshop`.`Translation` (`idTranslation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Order` (
  `idOrder` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idUser` INT UNSIGNED NOT NULL,
  `time` DATETIME NOT NULL,
  `status` SET('cart', 'ordered', 'payed', 'sent') NOT NULL DEFAULT 'cart',
  `shippingCosts` DECIMAL(6,2) NOT NULL,
  PRIMARY KEY (`idOrder`),
  INDEX `fk_Order_User1_idx` (`idUser` ASC),
  CONSTRAINT `fk_Order_User1`
    FOREIGN KEY (`idUser`)
    REFERENCES `webshop`.`User` (`idUser`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`OrderLine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`OrderLine` (
  `idOrderLine` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `idOrder` INT UNSIGNED NOT NULL,
  `idVariation` INT UNSIGNED NOT NULL,
  `amount` INT NOT NULL,
  `price` DECIMAL(6,2) NOT NULL,
  `tax` DECIMAL(6,2) NOT NULL,
  PRIMARY KEY (`idOrderLine`),
  INDEX `fk_OrderLine_Order1_idx` (`idOrder` ASC),
  INDEX `fk_OrderLine_Variation1_idx` (`idVariation` ASC),
  CONSTRAINT `fk_OrderLine_Order1`
    FOREIGN KEY (`idOrder`)
    REFERENCES `webshop`.`Order` (`idOrder`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_OrderLine_Variation1`
    FOREIGN KEY (`idVariation`)
    REFERENCES `webshop`.`Variation` (`idVariation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`Shop`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`Shop` (
  `idShop` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `shippingCosts` DECIMAL(6,2) NOT NULL,
  `shippingCostsThreshold` DECIMAL(6,2) NOT NULL,
  `defaultCombinationDiscount` DECIMAL(6,2) NOT NULL,
  `defaultTax` DECIMAL(6,2) NOT NULL,
  `idLanguage` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`idShop`),
  INDEX `fk_Shop_Language1_idx` (`idLanguage` ASC),
  CONSTRAINT `fk_Shop_Language1`
    FOREIGN KEY (`idLanguage`)
    REFERENCES `webshop`.`Language` (`idLanguage`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`SearchResult`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`SearchResult` (
  `idSearch` INT UNSIGNED NOT NULL,
  `idProduct` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idSearch`, `idProduct`),
  INDEX `fk_Search_has_Product_Product1_idx` (`idProduct` ASC),
  INDEX `fk_Search_has_Product_Search1_idx` (`idSearch` ASC),
  CONSTRAINT `fk_Search_has_Product_Search1`
    FOREIGN KEY (`idSearch`)
    REFERENCES `webshop`.`Search` (`idSearch`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_Search_has_Product_Product1`
    FOREIGN KEY (`idProduct`)
    REFERENCES `webshop`.`Product` (`idProduct`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`UserWish`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`UserWish` (
  `idUser` INT UNSIGNED NOT NULL,
  `idVariation` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idUser`, `idVariation`),
  INDEX `fk_User_has_Variation_Variation1_idx` (`idVariation` ASC),
  INDEX `fk_User_has_Variation_User1_idx` (`idUser` ASC),
  CONSTRAINT `fk_User_has_Variation_User1`
    FOREIGN KEY (`idUser`)
    REFERENCES `webshop`.`User` (`idUser`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_User_has_Variation_Variation1`
    FOREIGN KEY (`idVariation`)
    REFERENCES `webshop`.`Variation` (`idVariation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`ProductCategory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`ProductCategory` (
  `idProduct` INT UNSIGNED NOT NULL,
  `idCategory` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idProduct`, `idCategory`),
  INDEX `fk_ProductCategory_Category1_idx` (`idCategory` ASC),
  INDEX `fk_ProductCategory_Product1_idx` (`idProduct` ASC),
  CONSTRAINT `fk_ProductCategory_Product1`
    FOREIGN KEY (`idProduct`)
    REFERENCES `webshop`.`Product` (`idProduct`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ProductCategory_Category1`
    FOREIGN KEY (`idCategory`)
    REFERENCES `webshop`.`Category` (`idCategory`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`CategoryCombination`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`CategoryCombination` (
  `idCategory` INT UNSIGNED NOT NULL,
  `idCategory1` INT UNSIGNED NOT NULL,
  `discount` DECIMAL(6,2) NULL,
  PRIMARY KEY (`idCategory`, `idCategory1`),
  INDEX `fk_CategoryCategory_Category2_idx` (`idCategory1` ASC),
  INDEX `fk_CategoryCategory_Category1_idx` (`idCategory` ASC),
  CONSTRAINT `fk_CategoryCategory_Category1`
    FOREIGN KEY (`idCategory`)
    REFERENCES `webshop`.`Category` (`idCategory`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_CategoryCategory_Category2`
    FOREIGN KEY (`idCategory1`)
    REFERENCES `webshop`.`Category` (`idCategory`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`VariationFeatureValue`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`VariationFeatureValue` (
  `idVariation` INT UNSIGNED NOT NULL,
  `idFeatureValue` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idVariation`, `idFeatureValue`),
  INDEX `fk_VariationFeatureValue_FeatureValue1_idx` (`idFeatureValue` ASC),
  INDEX `fk_VariationFeatureValue_Variation1_idx` (`idVariation` ASC),
  CONSTRAINT `fk_VariationFeatureValue_Variation1`
    FOREIGN KEY (`idVariation`)
    REFERENCES `webshop`.`Variation` (`idVariation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_VariationFeatureValue_FeatureValue1`
    FOREIGN KEY (`idFeatureValue`)
    REFERENCES `webshop`.`FeatureValue` (`idFeatureValue`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `webshop`.`VariationImage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `webshop`.`VariationImage` (
  `idVariation` INT UNSIGNED NOT NULL,
  `idImage` INT UNSIGNED NOT NULL,
  `primary` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`idVariation`, `idImage`),
  INDEX `fk_VariationImage_Image1_idx` (`idImage` ASC),
  INDEX `fk_VariationImage_Variation1_idx` (`idVariation` ASC),
  CONSTRAINT `fk_VariationImage_Variation1`
    FOREIGN KEY (`idVariation`)
    REFERENCES `webshop`.`Variation` (`idVariation`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_VariationImage_Image1`
    FOREIGN KEY (`idImage`)
    REFERENCES `webshop`.`Image` (`idImage`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
