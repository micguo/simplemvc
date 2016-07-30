CREATE DATABASE Spoonity;

USE Spoonity;

CREATE TABLE `User` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `UNI_NAME` (`Name`),
  UNIQUE KEY `UNI_EMAIL` (`Email`),
  KEY `IDX_NAME` (`Name`),
  KEY `IDX_EMAIL` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
