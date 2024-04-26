-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 18, 2024 at 10:19 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Database: `praksaa`
--

-- --------------------------------------------------------
--
-- Table structure for table `delovi`
--
DROP TABLE IF EXISTS `delovi`;
CREATE TABLE IF NOT EXISTS `delovi` (
    `Sifra` varchar(191) NOT NULL,
    `Naziv` varchar(255) DEFAULT NULL,
    `VrstaMaterijala` varchar(255) DEFAULT NULL,
    `Precnik` decimal(10, 2) DEFAULT NULL,
    `Zastita` varchar(255) DEFAULT NULL,
    `KomadiIzSipke` int DEFAULT NULL,
    `MeraProizvodaGrami` decimal(10, 2) DEFAULT NULL,
    `PicturePath` varchar(255) DEFAULT NULL,
    `LargePicturePath` varchar(255) DEFAULT NULL,
    -- Added LargePicturePath column
    PRIMARY KEY (`Sifra`)
) ENGINE = MyISAM AUTO_INCREMENT = 234 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `delovi`
--
--
INSERT INTO `delovi` (
        `RedniBroj`,
        `Sifra`,
        `Naziv`,
        `VrstaMaterijala`,
        `Zastita`,
        `KomadiIzSipke`,
        `MeraProizvodaGrami`,
        `PicturePath`
    )
VALUES (
        33,
        '111',
        'Part1',
        'Drvo',
        'Novi Sad',
        2,
        '2.00',
        'uploads/logo (1).png'
    ),
    (
        233,
        '211',
        '211',
        '211',
        '211',
        2,
        '211.00',
        'uploads/logo.png'
    );
-- --------------------------------------------------------
--
-- Table structure for table `firm`
--

DROP TABLE IF EXISTS `firm`;
CREATE TABLE IF NOT EXISTS `firm` (
    `firmId` bigint NOT NULL,
    `name` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`firmId`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `firm`
--

INSERT INTO `firm` (`firmId`, `name`)
VALUES (85226035377511054, 'hshhshs'),
    (63234047096011481, 'Firma 1'),
    (30381414646592090, 'Firm4'),
    (16420823837455290, 'Peny Inc.'),
    (79175925564345703, 'Firma2'),
    (27429675502309984, 'Firma 3');
-- --------------------------------------------------------
--
-- Table structure for table `firm_orders`
--

DROP TABLE IF EXISTS `firm_orders`;
CREATE TABLE IF NOT EXISTS `firm_orders` (
    `firmId` bigint DEFAULT NULL,
    `orderId` bigint DEFAULT NULL,
    `status` enum('porucen', 'poslat') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `firm_orders`
--

INSERT INTO `firm_orders` (`firmId`, `orderId`, `status`)
VALUES (8457083591353975, 2, ''),
    (16420823837455290, 3, ''),
    (30432130986087209, 4, 'poslat'),
    (23335310776090525, 5, 'poslat'),
    (8457083591353975, 6, 'poslat'),
    (63234047096011481, 7, 'poslat'),
    (63234047096011481, 8, 'porucen'),
    (30381414646592090, 9, 'poslat');
-- --------------------------------------------------------
--
-- Table structure for table `materijali`
--

DROP TABLE IF EXISTS `materijali`;
CREATE TABLE IF NOT EXISTS `materijali` (
    `MaterijalID` int NOT NULL AUTO_INCREMENT,
    `Naziv` varchar(255) DEFAULT NULL,
    `Kolicina` decimal(10, 2) DEFAULT NULL,
    `Cijena` decimal(10, 2) DEFAULT NULL,
    PRIMARY KEY (`MaterijalID`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
-- Table structure for table `porudzbinastavke`
--

DROP TABLE IF EXISTS `porudzbinastavke`;
CREATE TABLE IF NOT EXISTS `porudzbinastavke` (
    `PorudzbinaID` int DEFAULT NULL,
    `ProizvodID` int DEFAULT NULL,
    `Kolicina` int DEFAULT NULL,
    KEY `PorudzbinaID` (`PorudzbinaID`),
    KEY `ProizvodID` (`ProizvodID`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
-- Table structure for table `porudzbine`
--

DROP TABLE IF EXISTS `porudzbine`;
CREATE TABLE IF NOT EXISTS `porudzbine` (
    `PorudzbinaID` int NOT NULL AUTO_INCREMENT,
    `SifraDela` varchar(255) DEFAULT NULL,
    `NazivDela` varchar(255) DEFAULT NULL,
    `DatumZaPovrsinskuZastitu` date DEFAULT NULL,
    `DatumZaTermickuObradu` date DEFAULT NULL,
    `DatumIsporukeDelova` date DEFAULT NULL,
    `Kolicina` int DEFAULT NULL,
    `BrojPotrebnihSipki` decimal(10, 2) DEFAULT NULL,
    PRIMARY KEY (`PorudzbinaID`)
) ENGINE = MyISAM AUTO_INCREMENT = 10 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `porudzbine`
--

INSERT INTO `porudzbine` (
        `PorudzbinaID`,
        `SifraDela`,
        `NazivDela`,
        `DatumZaPovrsinskuZastitu`,
        `DatumZaTermickuObradu`,
        `DatumIsporukeDelova`,
        `Kolicina`,
        `BrojPotrebnihSipki`
    )
VALUES (
        1,
        '233',
        '233',
        '2024-03-07',
        '2024-02-27',
        '2024-02-28',
        2,
        '1.00'
    ),
    (
        5,
        '1',
        '122',
        '2024-02-27',
        '2024-03-06',
        '2024-03-01',
        1,
        '1.00'
    ),
    (
        4,
        '233',
        '233',
        '2024-02-27',
        '2024-03-08',
        '2024-03-12',
        2,
        '2.00'
    ),
    (
        6,
        '233',
        '122',
        '2024-03-12',
        '2024-03-15',
        '2024-03-02',
        1,
        '1.00'
    ),
    (
        7,
        '233',
        '122',
        '2024-02-28',
        '2024-03-21',
        '2024-03-20',
        1,
        '1.00'
    ),
    (
        8,
        '232',
        '233',
        '2024-03-25',
        '2024-03-25',
        '2024-03-24',
        12,
        '45454.00'
    ),
    (
        9,
        '0034',
        'Traktor',
        '2024-03-15',
        '2024-03-20',
        '2024-03-01',
        2,
        '2.00'
    );
-- --------------------------------------------------------
--
-- Table structure for table `proizvodi`
--

DROP TABLE IF EXISTS `proizvodi`;
CREATE TABLE IF NOT EXISTS `proizvodi` (
    `ProizvodID` int NOT NULL AUTO_INCREMENT,
    `Naziv` varchar(255) DEFAULT NULL,
    `MaterijalID` int DEFAULT NULL,
    `KolicinaNaSkladistu` decimal(10, 2) DEFAULT NULL,
    PRIMARY KEY (`ProizvodID`),
    KEY `MaterijalID` (`MaterijalID`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;