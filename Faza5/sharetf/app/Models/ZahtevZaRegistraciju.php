<?php

/*
    Autor: Aleksa Vučković 2020/0035
*/

namespace App\Models;

use CodeIgniter\Model;

/**
 * ZahtevZaRegistraciju - Model za rad sa tabelom ZahtevZaRegistraciju
 */
class ZahtevZaRegistraciju extends Model
{
        protected $table      = 'zahtevzaregistraciju';
        protected $primaryKey = 'idzah';
        protected $returnType = 'array';
        protected $allowedFields = ['ime', 'prezime', 'email', 'lozinka', 'slika', 'tip'];
        

        /**
         * Briše zahtev id
         * 
         * @param int $id ID zahteva
         */
        public function removeRequest($id) {
            $ret = $this->find($id);
            $this->delete($id);
            return $ret;
        }

        /**
         * Dodaje zahtev
         * 
         * @param string $name Ime korisnika
         * @param string $lastname Prezime korisnika
         * @param string $email Email korisnika
         * @param string $password Lozinka
         * @param string $img Slika (može biti null)
         */
        public function addRequest($name, $lastName, $email, $password, $img) {
            $req = [
                'ime' => $name,
                'prezime' => $lastName,
                'email' => $email,
                'lozinka' => $password,
                'slika' => $img
            ];
            return $this->insert($req);
        }

        /**
         * Postavlja sliku na zahtev id
         * 
         * @param int $id ID zahteva koji se menja
         * @param string $img Nova putanja do slike
         */
        public function setImg($id, $img) {
            return $this->update($id, [
                'slika' => $img
            ]);
        }

        /**
         * Proverava da li postoji zahtev sa zadatom email adresom
         * 
         * @param string $email Email
         * 
         * @return boolean
         */
        public function exists($email) {
            return $this->where('email', $email)->first() != null;
        }
        
}