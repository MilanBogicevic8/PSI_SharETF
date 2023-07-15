<?php

/*
 * Milan Bogicevic 0284/2020
 */

namespace App\Models;

class AdminMethods{
    
    
        /**
         * Dohvata konekciju sa bazom podataka.
         * 
         * @return object Objekat za pristup bazi podataka
         */
        public function getDatabaseConnection() {
            return \Config\Database::connect();
        }  
      
        
        /**
         * Dohvata sve zahteve za registraciju iz baze.
         * 
         * @param object $db Objekat za pristup bazi podataka
         * @return array Niz objekata sa podacima zahteve za registraciju
         */
        public function getAllRegistrationRequests($db) {
            return $db->query("SELECT * FROM zahtevzaregistraciju")->getResult();
        }
        
        
         /**
         * Dohvata zahtev za registraciju iz baze na osnovu ID-ja.
         * 
         * @param object $db Objekat za pristup bazi podataka
         * @param int $id ID zahteva
         * @return object|bool Objekat sa podacima zahteva za registraciju ili false ako nije pronađen
         */
        public function getRegistrationRequestById($db, $id) {
            return $db->query("SELECT * FROM zahtevzaregistraciju WHERE IdZah = ?", [(int)$id])->getRow();
        }
        
        /**
         * Kreira korisnika na osnovu podataka zahteva za registraciju.
         * 
         * @param object $db Objekat za pristup bazi podataka
         * @param object $registrationRequest Objekat sa podacima zahteva za registraciju
         * @return void
         */
        public function createUserFromRegistrationRequest($db, $registrationRequest) {
            $db->query(
                "INSERT INTO korisnik (Ime, Prezime, Email, Lozinka, Slika, Tip) VALUES (?, ?, ?, ?, ?, ?)",
                [
                    $registrationRequest->Ime,
                    $registrationRequest->Prezime,
                    $registrationRequest->Email,
                    $registrationRequest->Lozinka,
                    $registrationRequest->Slika,
                    'R'
                ]
            );
        }
        
        /**
         * Briše zahtev za registraciju iz baze na osnovu ID-ja.
         * 
         * @param object $db Objekat za pristup bazi podataka
         * @param int $id ID zahteva
         * @return void
         */
        public function deleteRegistrationRequest($db, $id) {
            $db->query("DELETE FROM zahtevzaregistraciju WHERE IdZah = ?", [(int)$id]);
        }
    
    
}
