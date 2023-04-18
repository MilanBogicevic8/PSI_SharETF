insert into korisnik(ime, prezime, email, lozinka, slika, opis, tip) values("Aleksa", "Vučković", "va200035d@student.etf.bg.ac.rs", "123", "/uploads/prof3.png", "Zdravo svima.", 'A');
insert into korisnik(ime, prezime, email, lozinka, slika, opis, tip) values("Milan", "Bogićević", "bm200284d@student.etf.bg.ac.rs", "123", "/uploads/prof4.png", "Ja sam Milan, koautor ove aplikacije.", 'A');
insert into korisnik(ime, prezime, email, lozinka, slika, opis, tip) values("Petar", "Petrović", "pp200000d@student.etf.bg.ac.rs", "123", "/uploads/prof1.png", "Ja sam Petar i treća sam godina na SI.", 'R');
insert into korisnik(ime, prezime, email, lozinka, slika, opis, tip) values("Ana", "Anić", "aa200000d@student.etf.bg.ac.rs", "123", "/uploads/prof2.png", "Ja sam Ana i volim da pevam.", 'R');
insert into korisnik(ime, prezime, email, lozinka, slika, opis, tip) values("Sanja", "Sanjić", "ss200000d@student.etf.bg.ac.rs", "123", "/uploads/prof5.png", "Ćao, ja sam Sanja.", 'R');
insert into korisnik(ime, prezime, email, lozinka, slika, opis, tip) values("Jana", "Janić", "jj200000d@student.etf.bg.ac.rs", "123", "/uploads/prof6.png", "Ja sam Jana i treća sam godina na SI. Iz Beograda sam i imam 22 godine. Volim da putujem i da se družim. Omiljeno jelo mi je sarajevski ćevap.", 'R');


insert into grupa(naziv, opis, slika) values("ETF", "Grupa za sve studente ETF-a, za teme u vezi sa upisom, studijama, prijavi ispita i dr. Pitanja u vezi sa pojedinim predmetima postavite u odgovarajućoj grupi, ne ovde!", "/uploads/etf.jpg");
insert into grupa(naziv, opis, slika) values("Sistemski Softver (13S113SS)", "Predmet na trećoj godini studija.", "/uploads/group2.png");
insert into grupa(naziv, opis, slika) values("Veb Dizajn (13S113VD)", "Predmet na drugoj i trećoj godini studija.", "/uploads/group1.png");

insert into objava(tekst, slika, datumvreme, idk, idg) values("Ovo je moja prva objava!", null, "2023-02-01 12:20:00", 3, null);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Volim sistemski softver. Najbolji predmet na fakultetu!", null, "2023-02-09 10:21:00", 3, 2);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Do kada mogu da se prijave ispiti za februarski rok?", null, "2023-02-05 12:19:55", 3, 1);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Ja sam Ana i ovo je moja prva objava!", null, "2023-02-06 17:10:00", 4, null);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Ja sam Ana i ovo je moja druga objava!", null, "2023-02-01 17:10:45", 4, null);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Veb dizajn je bio odličan izbor, zaista.", null, "2023-03-06 16:20:00", 1, 3);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Dobro došli na našu društvenu mrežu!", null, "2023-02-01 12:00:00", 2, 1);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Ja sam Sanja.", null, "2023-04-01 13:24:01", 5, null);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Javascript mi ide kao od šale.", null, "2023-04-02 14:10:02", 5, 3);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Sjajan je ovaj sajt!", null, "2023-04-05 10:20:00", 5, 1);
insert into objava(tekst, slika, datumvreme, idk, idg) values("Ovo je moja prva objava!", null, "2023-04-15 08:41:15", 6, null);

insert into jeclan values(3,2);
insert into jeclan values(3,1);
insert into jeclan values(1,3);
insert into jeclan values(2,1);
insert into jeclan values(5,3);
insert into jeclan values(5,1);
insert into jeclan values(1,1);
insert into jeclan values(1,2);

insert into jeprijatelj values(1,3);
insert into jeprijatelj values(1,4);
insert into jeprijatelj values(1,2);
insert into jeprijatelj values(1,5);
insert into jeprijatelj values(1,6);
insert into jeprijatelj values(2,3);
insert into jeprijatelj values(2,4);
insert into jeprijatelj values(2,5);
insert into jeprijatelj values(2,6);
insert into jeprijatelj values(4,5);
insert into jeprijatelj values(4,6);
insert into jeprijatelj values(3,6);

insert into komentar(idk, idobj, tekst) values(1, 1, "Super ti je objava.");
insert into komentar(idk, idobj, tekst) values(1, 11, "Dobrodošla!");
insert into komentar(idk, idobj, tekst) values(4, 7, "Svaka vam čast.");
insert into komentar(idk, idobj, tekst) values(5, 7, "Sjajna ideja, sjajno sprovedena u delo.");
insert into komentar(idk, idobj, tekst) values(6, 7, "wow");

insert into lajkovao values(1,1);
insert into lajkovao values(1,2);
insert into lajkovao values(1,3);
insert into lajkovao values(1,4);
insert into lajkovao values(1,5);
insert into lajkovao values(1,6);
insert into lajkovao values(1,9);
insert into lajkovao values(1,10);
insert into lajkovao values(1,11);
insert into lajkovao values(2,5);
insert into lajkovao values(2,6);
insert into lajkovao values(2,9);
insert into lajkovao values(3,7);
insert into lajkovao values(4,7);
insert into lajkovao values(5,7);
insert into lajkovao values(6,7);

insert into zahtevzaprijateljstvo values(3, 4);
insert into zahtevzaprijateljstvo values(3, 5);
insert into zahtevzaprijateljstvo values(6, 5);

insert into zahtevzaregistraciju(ime, prezime, email, lozinka, slika) values("Ranko", "Ranković", "rr200000d@student.etf.bg.ac.rs", "123", "/uploads/default.jpg");