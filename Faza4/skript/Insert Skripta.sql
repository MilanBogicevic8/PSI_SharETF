-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: sharetf
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `grupa`
--

LOCK TABLES `grupa` WRITE;
/*!40000 ALTER TABLE `grupa` DISABLE KEYS */;
INSERT INTO `grupa` VALUES (1,'ETF','Grupa za sve studente ETF-a, za teme u vezi sa upisom, studijama, prijavi ispita i dr. Pitanja u vezi sa pojedinim predmetima postavite u odgovarajućoj grupi, ne ovde!','/uploads/etf.jpg'),(2,'Sistemski Softver (13S113SS)','Predmet na trećoj godini studija.','/uploads/group2.png'),(3,'Veb Dizajn (13S113VD)','Predmet na drugoj i trećoj godini studija.','/uploads/group1.png'),(4,'Konkurentno i distribuirano programiranje (13S113KDP)','Predmet na trećej godini studija za smerove RTI i SI, na kom se obrađuju sinhronizacioni algoritmi, semafori, monitori, međuprocesna komunikacija...','/uploads/grupa-4.jpg'),(5,'Računarska grafika (13S113RG)','Predmet u šestom semestru SI smera. Predavač - Igor Tartalja.','/uploads/grupa-5.jpg'),(6,'Arhitektura računara (13S112AR)','Najdosadniji predmet na fakultetu.','/uploads/grupa-6.jpg'),(7,'Objektno orijentisano programiranje 2 (13S112OO2)','Java programski jezik i malo C#. Predavač - Igor Tartalja.','/uploads/grupa-7.png');
/*!40000 ALTER TABLE `grupa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `jeclan`
--

LOCK TABLES `jeclan` WRITE;
/*!40000 ALTER TABLE `jeclan` DISABLE KEYS */;
INSERT INTO `jeclan` VALUES (4,1),(4,4),(5,1),(5,5),(7,2),(7,4),(9,1),(9,3),(10,2),(14,1),(14,2),(14,3),(14,4);
/*!40000 ALTER TABLE `jeclan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `jeprijatelj`
--

LOCK TABLES `jeprijatelj` WRITE;
/*!40000 ALTER TABLE `jeprijatelj` DISABLE KEYS */;
INSERT INTO `jeprijatelj` VALUES (1,2),(1,4),(1,5),(1,7),(2,4),(2,6),(2,7),(2,8),(3,5),(3,8),(3,9),(3,10),(3,11),(3,12),(3,13),(3,14),(3,15),(4,5),(4,7),(4,10),(4,12),(4,13),(4,14),(5,6),(5,13),(5,14),(5,15),(6,7),(6,8),(6,10),(6,11),(6,12),(6,13),(7,9),(7,10),(7,11),(7,13),(7,14),(7,15),(8,9),(8,10),(8,12),(8,13),(9,10),(9,15),(10,11),(10,12),(10,13),(10,14),(10,15),(11,12),(11,13),(11,14),(11,15),(12,13),(12,14),(12,15),(13,14),(13,15),(14,15);
/*!40000 ALTER TABLE `jeprijatelj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `komentar`
--

LOCK TABLES `komentar` WRITE;
/*!40000 ALTER TABLE `komentar` DISABLE KEYS */;
INSERT INTO `komentar` VALUES (1,5,4,'Mislim da je do 25.'),(2,5,4,' Mada nisam baš sigurna.'),(3,8,2,'Jeste, bilo bi dobro samo da postoje privatni četovi... I da postoji aplikacija za telefon, e to bi bilo idealno.'),(4,8,9,'Video sam ga ja danas bio je na stolici u uglu prve prostorije.'),(5,7,13,'HAHAHAH SAME '),(6,7,6,'Ko nije...'),(7,7,4,'Jeste 25 100%'),(8,9,15,'Danice, odrasti wtf'),(9,9,14,'Realno Go nikad nije i dosao, a Ada jednom u sto godina... Bolje uci nesto drugo.'),(10,9,11,'Otkad se ti bavis poezijom'),(11,10,23,'Interesuje me koji je tezi, koji zanimnljiviji itd.'),(12,14,21,'Nemoj vise pobogu!'),(13,14,23,'Ja bih ti preporucio SS, korisnije je, mada je malo teze.'),(14,14,14,'budite spremni na sve');
/*!40000 ALTER TABLE `komentar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `korisnik`
--

LOCK TABLES `korisnik` WRITE;
/*!40000 ALTER TABLE `korisnik` DISABLE KEYS */;
INSERT INTO `korisnik` VALUES (1,'Aleksa','Vučković','va200035d@student.etf.bg.ac.rs','123','/uploads/prof3.png','Zdravo svima.','A'),(2,'Milan','Bogićević','bm200284d@student.etf.bg.ac.rs','123','/uploads/prof4.png','Ja sam Milan, koautor ove aplikacije.','A'),(3,'Ana','Anić','aa200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-1.jpg','Zdravo svima ja sam Ana Anić! Ja sam studentkinja 4. godina ETF-a na smeru za telekomunikacije.','R'),(4,'Bojana','Bojanić','bb200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-2.jpg','\"The way I see it, if you want the rainbow, you gotta put up with the rain.\"','R'),(5,'Vanja','Vanjić','vv200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-3.jpg','“Be yourself; everyone else is already taken.”','R'),(6,'Gordana','Gordanić','gg200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-4.jpg','“I\'m selfish, impatient and a little insecure. I make mistakes, I am out of control and at times hard to handle. But if you can\'t handle me at my worst, then you sure as hell don\'t deserve me at my best.”','R'),(7,'Danica','Daničić','dd200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-5.jpg','...','R'),(8,'Marko','Marković','mm200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-6.jpg','HI EVERYONE!\r\nHI EVERYONE!\r\nHI EVERYONE!','R'),(9,'Nemanja','Nemanjić','nn200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-7.jpg','Pobednik mi je srednje ime.','R'),(10,'Petar','Petrović','pp200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-8.jpg','“You know you\'re in love when you can\'t fall asleep because reality is finally better than your dreams.”','R'),(11,'Atanasije','Boričić','ab200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-12.jpg','Ne znam šta da stavim u opis??','R'),(12,'Branko','Vojinović','bv200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-13.jpg','Ovo je moj veoooooooooooooooooma veooooooooooooooooooooooma veoooooooooooooooooooooooooooma veoooooooooooooooooooooooooooooooooooooooma veoooooooooooooooooooooooma veoooooooooooooooooooooooooooma veoooooooooooooooooooooooooooma veooooooooooooooooooooooooooma veoooooooooooooooooooooooooooooooooma veoooooooooooooooooooooooooooooooma veoooooooooooooooooooooooooooma veoooooooooooooooooooooooooooma veoooooooooooooooooooooooooooooooma veooooooooooooooooooooooooooooma veooooooooooooooooooooooooooooma veoooooooooooooooooooooooooooooooma dugačak opis.','R'),(13,'Vladan','Drašković','vd200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-14.jpg','Zašto psi ne umeju da plešu? ...................Imaju dve leve noge.','R'),(14,'Dražen','Drašković','dd200001d@student.etf.bg.ac.rs','123','/uploads/zahtev-10.jpg','','R'),(15,'Tamara','Šekularac','ts200001d@student.etf.bg.ac.rs','123','/uploads/zahtev-11.jpg','','R');
/*!40000 ALTER TABLE `korisnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `lajkovao`
--

LOCK TABLES `lajkovao` WRITE;
/*!40000 ALTER TABLE `lajkovao` DISABLE KEYS */;
INSERT INTO `lajkovao` VALUES (3,1),(5,4),(5,5),(5,6),(5,8),(5,9),(5,10),(5,13),(5,25),(6,11),(6,12),(6,13),(7,4),(7,5),(7,6),(7,13),(8,1),(8,2),(8,12),(9,4),(9,9),(9,11),(9,14),(9,15),(9,16),(10,15),(10,17),(10,23),(14,9),(14,16),(14,17),(14,23),(14,24);
/*!40000 ALTER TABLE `lajkovao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `objava`
--

LOCK TABLES `objava` WRITE;
/*!40000 ALTER TABLE `objava` DISABLE KEYS */;
INSERT INTO `objava` VALUES (1,'Zdravo svima!!!',NULL,'2023-06-11 14:41:43',3,NULL),(2,'Sjajna je ova aplikacija.',NULL,'2023-06-11 14:42:03',3,NULL),(3,'Ovo je moja prva objava.',NULL,'2023-06-11 15:38:32',4,NULL),(4,'Do kada ja rok za uplatu poslednje rate za školarinu??',NULL,'2023-06-11 15:39:12',4,1),(5,'Bilo bi lepo da se objave rezultati lab2 pre popravke...',NULL,'2023-06-11 15:39:57',4,4),(6,'Baš sam mrzela ovaj predmet tbh.',NULL,'2023-06-11 15:40:29',4,6),(7,'Pozdrav svim mojim prijateljima!\r\nHello to all my friends!','/uploads/objava-7.png','2023-06-11 15:42:45',5,NULL),(8,'Here is a poem I found on the web the other day:\r\nUpon the road of my life,\r\nPassed me many fair creatures,\r\nClothed all in white, and radiant.\r\nTo one, finally, I made speech:\r\n\"Who art thou?\"\r\nBut she, like the others,\r\nKept cowled her face,\r\nAnd answered in haste, anxiously,\r\n\"I am good deed, forsooth;\r\nYou have often seen me.\"',NULL,'2023-06-11 15:45:37',5,NULL),(9,'Mislim da mi je juče ostao telefon iPhone 11 u RC, ako ga neko nađe nek mi javi pls.',NULL,'2023-06-11 15:50:42',5,1),(10,'Zaboravila sam da prijavim ispit, je l ima vajde da šaljem mejl??',NULL,'2023-06-11 15:51:46',5,5),(11,'Upon the road of my life,\r\nPassed me many fair creatures,\r\nClothed all in white, and radiant.\r\nTo one, finally, I made speech:\r\n\"Who art thou?\"\r\nBut she, like the others,\r\nKept cowled her face,\r\nAnd answered in haste, anxiously,\r\n\"I am good deed, forsooth;\r\nYou have often seen me.\"',NULL,'2023-06-11 16:01:44',8,NULL),(12,'','/uploads/objava-12.jpg','2023-06-11 16:09:33',8,NULL),(13,'Ja za KDP:','/uploads/objava-13.jpg','2023-06-11 16:18:03',6,NULL),(14,'Koje su šanse da dođe neko pitanje iz Go ili Ade u julskom roku?',NULL,'2023-06-11 16:20:45',7,4),(15,'Prva',NULL,'2023-06-11 16:21:24',7,2),(16,'Prezentacija stipendija i praksi kompanije BGI će se održati 26.04.2023. u sali 56 od 15 časova.\r\n\r\nViše o kompaniji i predavanju možete naći na :\r\nhttps://www.etf.bg.ac.rs/sr/najave/2023/04/forging-ahead-for-23-years-from-the-human-genome-project-to-the-spatiotemporal-omics-consortium-internships-and-scholarships-for-studying-in-serbia-and-china \r\n\r\nVidimo se u što većem broju!','/uploads/objava-16.png','2023-06-11 16:45:04',9,1),(17,'Preporucujem svima ovaj predmet.',NULL,'2023-06-11 16:46:31',9,3),(18,'spam',NULL,'2023-06-11 16:47:25',10,NULL),(19,'spam',NULL,'2023-06-11 16:47:28',10,NULL),(20,'spam',NULL,'2023-06-11 16:47:31',10,NULL),(21,'spam',NULL,'2023-06-11 16:47:35',10,NULL),(22,'spam\r\n',NULL,'2023-06-11 16:47:39',10,NULL),(23,'Da li da uzmem ovaj predmet ili racunarsku grafiku?? Ako ima neko ko je bio na oba...',NULL,'2023-06-11 16:48:52',10,2),(24,'Zelim vam puno srece u predstojecem junskom ispitnom roku!',NULL,'2023-06-11 16:53:17',14,1),(25,'','/uploads/objava-25.jpg','2023-06-11 16:56:36',14,NULL),(26,'Dobar dan svima...',NULL,'2023-06-11 16:57:51',1,NULL),(27,'Ne mogu vise da ucim...',NULL,'2023-06-11 17:00:01',5,NULL);
/*!40000 ALTER TABLE `objava` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zahtevzaprijateljstvo`
--

LOCK TABLES `zahtevzaprijateljstvo` WRITE;
/*!40000 ALTER TABLE `zahtevzaprijateljstvo` DISABLE KEYS */;
INSERT INTO `zahtevzaprijateljstvo` VALUES (1,6),(4,6),(8,14),(14,1),(14,2);
/*!40000 ALTER TABLE `zahtevzaprijateljstvo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `zahtevzaregistraciju`
--

LOCK TABLES `zahtevzaregistraciju` WRITE;
/*!40000 ALTER TABLE `zahtevzaregistraciju` DISABLE KEYS */;
INSERT INTO `zahtevzaregistraciju` VALUES (9,'Ranko','Ranković','rr200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-9.jpg'),(15,'Darko','Petronijević','dp200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-15.jpg'),(16,'Tanasko','Tanasković','tt200000d@student.etf.bg.ac.rs','123','/uploads/zahtev-16.jpg');
/*!40000 ALTER TABLE `zahtevzaregistraciju` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-06-11 21:03:33
