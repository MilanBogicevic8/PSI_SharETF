DROP DATABASE IF EXISTS `ShareETF`;
CREATE DATABASE `ShareETF`;
USE `ShareETF`;

CREATE TABLE Korisnik
(
IdK int NOT NULL AUTO_INCREMENT ,
Ime varchar(200) NOT NULL ,
Prezime varchar(200) NOT NULL ,
Email varchar(200) NOT NULL ,
Lozinka varchar(200) NOT NULL ,
Slika varchar(100) NOT NULL ,
Opis varchar(1000) NOT NULL ,
Tip char NOT NULL ,
PRIMARY KEY (IdK),
UNIQUE KEY email (Email)
);

CREATE TABLE Objava
(
IdObj int NOT NULL AUTO_INCREMENT ,
Tekst varchar(1000) NOT NULL ,
Slika varchar(100) NULL ,
DatumVreme datetime NOT NULL ,
IdK int NOT NULL ,
PRIMARY KEY (IdObj),
FOREIGN KEY (IdK) REFERENCES Osoba(IdK)
ON DELETE NO ACTION
ON UPDATE CASCADE
);

CREATE TABLE Grupa
(
IdG int NOT NULL AUTO_INCREMENT ,
Naziv varchar(200) NOT NULL ,
Opis varchar(200) NOT NULL ,
Slika varchar(100) NOT NULL ,
PRIMARY KEY (IdG)
);

CREATE TABLE GrupnaObjava
(
IdObj int NOT NULL ,
IdG int NOT NULL ,
PRIMARY KEY (IdObj),
FOREIGN KEY (IdObj) REFERENCES Objava(IdObj)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY (IdG) REFERENCES Grupa(IdG)
ON DELETE NO ACTION
ON UPDATE CASCADE
);

CREATE TABLE JeClan
(
IdK int NOT NULL ,
IdG int NOT NULL ,
PRIMARY KEY (IdK, IdG),
FOREIGN KEY (IdK) REFERENCES Osoba(IdK)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY (IdG) REFERENCES Grupa(IdG)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE JePrijatelj
(
IdK1 int NOT NULL ,
IdK2 int NOT NULL ,
PRIMARY KEY (IdK1, IdK2),
FOREIGN KEY (IdK1) REFERENCES Osoba(IdK)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY (IdK2) REFERENCES Osoba(IdK)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE Komentar
(
IdK int NOT NULL ,
IdObj int NOT NULL ,
Tekst varchar(1000) NOT NULL ,
IdKom char(18) NOT NULL ,
PRIMARY KEY (IdKom),
FOREIGN KEY (IdK) REFERENCES Osoba(IdK)
ON DELETE NO ACTION
ON UPDATE CASCADE,
FOREIGN KEY (IdObj) REFERENCES Objava(IdObj)
ON DELETE NO ACTION
ON UPDATE CASCADE
);


CREATE TABLE Lajkovao (
IdK int NOT NULL,
IdObj int NOT NULL,
PRIMARY KEY (IdK,IdObj),
FOREIGN KEY (IdK) REFERENCES Osoba(IdK) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (IdObj) REFERENCES Objava(IdObj) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ProfilnaObjava (
IdObj int NOT NULL,
PRIMARY KEY (IdObj),
FOREIGN KEY (IdObj) REFERENCES Objava(IdObj) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ZahtevZaPrijateljstvo (
IdK1 int NOT NULL,
IdK2 int NOT NULL,
PRIMARY KEY (IdK1,IdK2),
FOREIGN KEY (IdK1) REFERENCES Osoba(IdK) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (IdK2) REFERENCES Osoba(IdK) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ZahtevZaRegistraciju (
IdZah int NOT NULL,
Ime varchar(200) NOT NULL,
Prezime varchar(200) NOT NULL,
Email varchar(200) NOT NULL,
Lozinka varchar(200) NOT NULL,
Slika varchar(100) NOT NULL,
PRIMARY KEY (IdZah)
);