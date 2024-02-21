create database praksaa;
use praksaa;


-- Kreiranje tablice Materijali
CREATE TABLE Materijali (
    MaterijalID INT PRIMARY KEY AUTO_INCREMENT,
    Naziv VARCHAR(255),
    Kolicina DECIMAL(10,2),
    Cijena DECIMAL(10,2)
);

-- Kreiranje tablice Proizvodi
CREATE TABLE Proizvodi (
    ProizvodID INT PRIMARY KEY AUTO_INCREMENT,
    Naziv VARCHAR(255),
    MaterijalID INT,
    KolicinaNaSkladistu DECIMAL(10,2),
    FOREIGN KEY (MaterijalID) REFERENCES Materijali(MaterijalID)
);

-- Kreiranje tablice Porudzbine
CREATE TABLE Porudzbine (
    PorudzbinaID INT PRIMARY KEY AUTO_INCREMENT,
    DatumPorudzbine DATE,
    DatumIsporuke DATE
);

-- Tablica koja povezuje Proizvode i Porudzbine
CREATE TABLE PorudzbinaStavke (
    PorudzbinaID INT,
    ProizvodID INT,
    Kolicina INT,
    FOREIGN KEY (PorudzbinaID) REFERENCES Porudzbine(PorudzbinaID),
    FOREIGN KEY (ProizvodID) REFERENCES Proizvodi(ProizvodID)
);
