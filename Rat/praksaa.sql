drop database praksaa;
create database praksaa;
use praksaa;
-- Kreiranje tablice Materijali
CREATE TABLE Materijali (
    MaterijalID INT PRIMARY KEY AUTO_INCREMENT,
    Naziv VARCHAR(255),
    Kolicina DECIMAL(10, 2),
    Cijena DECIMAL(10, 2)
);
-- Kreiranje tablice Proizvodi
CREATE TABLE Proizvodi (
    ProizvodID INT PRIMARY KEY AUTO_INCREMENT,
    Naziv VARCHAR(255),
    MaterijalID INT,
    KolicinaNaSkladistu DECIMAL(10, 2),
    FOREIGN KEY (MaterijalID) REFERENCES Materijali(MaterijalID)
);
/*-- Kreiranje tablice Porudzbine
 CREATE TABLE Porudzbine (
 PorudzbinaID INT PRIMARY KEY AUTO_INCREMENT,
 DatumPorudzbine DATE,
 DatumIsporuke DATE
 );*/
-- Tablica koja povezuje Proizvode i Porudzbine
CREATE TABLE PorudzbinaStavke (
    PorudzbinaID INT,
    ProizvodID INT,
    Kolicina INT,
    FOREIGN KEY (PorudzbinaID) REFERENCES Porudzbine(PorudzbinaID),
    FOREIGN KEY (ProizvodID) REFERENCES Proizvodi(ProizvodID)
);
-- Kreiranje tablice Delovi
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
CREATE TABLE Porudzbine (
    PorudzbinaID INT PRIMARY KEY AUTO_INCREMENT,
    SifraDela VARCHAR(255),
    NazivDela VARCHAR(255),
    DatumZaPovrsinskuZastitu DATE,
    DatumZaTermickuObradu DATE,
    DatumIsporukeDelova DATE,
    Kolicina INT,
    BrojPotrebnihSipki DECIMAL(10, 2)
);