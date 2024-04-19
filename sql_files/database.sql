DROP DATABASE IF EXISTS `hospital`;

CREATE DATABASE `hospital`;
USE `hospital`;

CREATE TABLE `Patient` (
	`Patient_ID` INT(11) AUTO_INCREMENT,
    `First_Name` VARCHAR(50) NOT NULL,
    `Last_Name` VARCHAR(50) NOT NULL,
    `Photo_Url` VARCHAR(255) NOT NULL,
    `Birthday` DATE NOT NULL,
    `Gender` VARCHAR(50) NOT NULL,
    `Address` VARCHAR(100) NOT NULL,
    `Phone` VARCHAR(20) NOT NULL,
    `Email` VARCHAR(255) NOT NULL,
    `Password` CHAR(64) NOT NULL,
    UNIQUE (`Patient_ID`, `Phone`, `Email`),
    PRIMARY KEY (`Patient_ID`)
);

CREATE TABLE `Doctor` (
	`Doctor_ID` INT(11) AUTO_INCREMENT,
    `Doc_First_Name` VARCHAR(50) NOT NULL,
    `Doc_Last_Name` VARCHAR(50) NOT NULL,
    `Doc_Photo_Url` VARCHAR(255) NOT NULL,
   	`Speciality` VARCHAR(50) NOT NULL,
    `Doc_Phone` VARCHAR(20) NOT NULL,
    `Doc_Email` VARCHAR(255) NOT NULL,
    `Doc_Password` CHAR(64) NOT NULL,
    UNIQUE (`Doctor_ID`, `Doc_Phone`, `Doc_Email`),
    PRIMARY KEY (`Doctor_ID`)
);

CREATE TABLE `Reception` (
	`Reception_ID` INT(11) AUTO_INCREMENT,
    `Patient_ID` INT(11) NOT NULL,
    `Doctor_ID` INT(11) NOT NULL,
    `Rec_Date` DATE NOT NULL DEFAULT NOW(),
    `Rec_Time` TIME NOT NULL DEFAULT NOW(),
    UNIQUE (`Reception_ID`),
    PRIMARY KEY (`Reception_ID`),
    FOREIGN KEY (`Patient_ID`) REFERENCES `Patient` (`Patient_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`Doctor_ID`) REFERENCES `Doctor` (`Doctor_ID`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `Diagnosis` (
	`Diagnosis_ID` INT(11) AUTO_INCREMENT,
    `Doctor_ID` INT(11) NOT NULL,
    `Patient_ID` INT(11) NOT NULL,
    `Diagnosis_Name` VARCHAR(100) NOT NULL,
    `Diagnosis_Notes` TEXT NOT NULL,
    `Diagnosis_Date` DATE NOT NULL DEFAULT NOW(),
    `Diagnosis_File` VARCHAR(255) NOT NULL,
    UNIQUE (`Diagnosis_ID`),
    PRIMARY KEY (`Diagnosis_ID`),
    FOREIGN KEY (`Patient_ID`) REFERENCES `Patient` (`Patient_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`Doctor_ID`) REFERENCES `Doctor` (`Doctor_ID`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `Medicine` (
	`Medicine_ID` INT(11) AUTO_INCREMENT,
    `Diagnosis_ID` INT(11) NOT NULL,
    `Doctor_ID` INT(11) NOT NULL,
    `Patient_ID` INT(11) NOT NULL,
    `Medicine_Name` VARCHAR(100) NOT NULL,
    `Medicine_Prescription` TEXT NOT NULL,
    `Treatment_Date` DATE NOT NULL DEFAULT NOW(),
    UNIQUE (`Medicine_ID`),
    PRIMARY KEY (`Medicine_ID`),
    FOREIGN KEY (`Diagnosis_ID`) REFERENCES `Diagnosis` (`Diagnosis_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`Patient_ID`) REFERENCES `Patient` (`Patient_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`Doctor_ID`) REFERENCES `Doctor` (`Doctor_ID`) ON DELETE CASCADE ON UPDATE CASCADE
);