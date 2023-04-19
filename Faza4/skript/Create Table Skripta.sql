DROP DATABASE IF EXISTS `SharETF`;
CREATE DATABASE `SharETF`;
USE `SharETF`;

CREATE TABLE Korisnik
(
IdK int PRIMARY KEY AUTO_INCREMENT ,
Ime varchar(200) NOT NULL ,
Prezime varchar(200) NOT NULL ,
Email varchar(200) UNIQUE NOT NULL ,
Lozinka varchar(200) NOT NULL ,
Slika varchar(100) NOT NULL ,
Opis varchar(1000) NOT NULL ,
Tip char NOT NULL CHECK(Tip = 'A' OR Tip = 'R')
);

CREATE TABLE Grupa
(
IdG int PRIMARY KEY AUTO_INCREMENT ,
Naziv varchar(200) NOT NULL ,
Opis varchar(1000) NOT NULL ,
Slika varchar(100) NOT NULL
);

CREATE TABLE Objava
(
IdObj int PRIMARY KEY AUTO_INCREMENT ,
Tekst varchar(1000) NOT NULL ,
Slika varchar(100) DEFAULT NULL ,
DatumVreme timestamp NOT NULL ,
IdK int NOT NULL ,
IdG int DEFAULT NULL, 
FOREIGN KEY (IdK) REFERENCES Korisnik(IdK)
ON DELETE NO ACTION
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
FOREIGN KEY (IdK) REFERENCES Korisnik(IdK)
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
FOREIGN KEY (IdK1) REFERENCES Korisnik(IdK)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY (IdK2) REFERENCES Korisnik(IdK)
ON DELETE CASCADE
ON UPDATE CASCADE
);

CREATE TABLE Komentar
(
IdKom int PRIMARY KEY AUTO_INCREMENT ,
IdK int NOT NULL,
IdObj int NOT NULL ,
Tekst varchar(1000) NOT NULL ,
FOREIGN KEY (IdK) REFERENCES Korisnik(IdK)
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
FOREIGN KEY (IdK) REFERENCES Korisnik(IdK) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (IdObj) REFERENCES Objava(IdObj) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ZahtevZaPrijateljstvo (
IdK1 int NOT NULL,
IdK2 int NOT NULL,
PRIMARY KEY (IdK1,IdK2),
FOREIGN KEY (IdK1) REFERENCES Korisnik(IdK) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (IdK2) REFERENCES Korisnik(IdK) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ZahtevZaRegistraciju (
IdZah int PRIMARY KEY AUTO_INCREMENT,
Ime varchar(200) NOT NULL,
Prezime varchar(200) NOT NULL,
Email varchar(200) NOT NULL,
Lozinka varchar(200) NOT NULL,
Slika varchar(100) NOT NULL
);


delimiter $$
create function likenum(
	postid int
) 
returns int
begin
	declare ret int;
	select count(*) into ret from lajkovao where idobj = postid;
    return ret;
END$$

create function liked( postid int, userid int ) returns int
begin
	declare ret int;
	select count(*) into ret from lajkovao where idobj = postid and idk = userid;
    return ret;
end$$

create function commentnum( postid int ) returns int
begin
	declare ret int;
	select count(*) into ret from komentar where idobj = postid;
    return ret;
end$$

create function arefriends( user1 int, user2 int ) returns boolean
begin
	declare ret boolean;
    select exists(select * from jeprijatelj where idk1 = user1 and idk2 = user2 or idk1 = user2 and idk2 = user1) into ret;
    select (ret or (user1 = user2)) into ret;
    return ret;
end$$

create function ismember( groupid int, userid int ) returns boolean
begin
	declare ret boolean;
    select exists(select * from jeclan where idk = userid and idg = groupid) into ret;
    return ret;
end$$

delimiter ;