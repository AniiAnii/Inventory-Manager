 Table structure for table `delovi`
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
    PRIMARY KEY (`Sifra`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;



-- --------------------------------------------------------
-- Table structure for table `firm`
--
DROP TABLE IF EXISTS `firm`;
CREATE TABLE IF NOT EXISTS `firm` (
    `firmId` bigint NOT NULL,
    `name` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`firmId`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;



-- --------------------------------------------------------
-- Table structure for table `firm_orders`
--
DROP TABLE IF EXISTS `firm_orders`;
CREATE TABLE IF NOT EXISTS `firm_orders` (
    `firmId` bigint DEFAULT NULL,
    `orderId` bigint DEFAULT NULL,
    `status` enum('porucen', 'poslat') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `materijali`;
CREATE TABLE IF NOT EXISTS `materijali` (
    `MaterijalID` int NOT NULL AUTO_INCREMENT,
    `Naziv` varchar(255) DEFAULT NULL,
    `Kolicina` decimal(10, 2) DEFAULT NULL,
    `Cijena` decimal(10, 2) DEFAULT NULL,
    PRIMARY KEY (`MaterijalID`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;



-- --------------------------------------------------------
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



-- --------------------------------------------------------
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

