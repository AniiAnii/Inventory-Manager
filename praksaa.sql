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
CREATE TABLE Delovi (
    RedniBroj INT PRIMARY KEY AUTO_INCREMENT,
    Sifra VARCHAR(255),
    Naziv VARCHAR(255),
    VrstaMaterijala VARCHAR(255),
    Zastita VARCHAR(255),
    KomadiIzSipke INT,
    MeraProizvodaGrami DECIMAL(10, 2)
);
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
CREATE TABLE firm (
    firmId BIGINT PRIMARY KEY,
    name VARCHAR(255)
);
