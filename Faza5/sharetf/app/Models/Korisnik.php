<?php 

/*
    Autor: Aleksa Vučković 2020/0035
*/

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

/**
 * Korisnik - Model za rad sa tabelom korisnik, ali i sa tabelom jeprijatelj
 */
class Korisnik extends Model
{
        protected $table      = 'korisnik';
        protected $primaryKey = 'idk';
        protected $returnType = 'array';
        protected $allowedFields = ['ime', 'prezime', 'email', 'lozinka', 'slika', 'opis', 'tip'];
        

        /**
         * Dohvata korisnika sa zadatom email adresom
         * 
         * @param string $email Email adresa
         * 
         * @return array
         */
        public function getUser($email) {
            return $this->where('email', $email)->first();
        }
        /**
         * Dohvata korisnika sa zadatim id
         * 
         * @param int $id ID korisnika
         * 
         * @return array
         */
        public function getUserById($id) {
            return $this->find($id);
        }

        /**
         * Preimeinuje niz $user tako da imena polja odgovaraju imenima koja se zahtevaju u view
         * 
         * @param array $user Niz vraćen iz getUser() ili getUserById()
         * 
         * @return array
         */
        public function rename($user) {
            return ['id' => (int)$user['IdK'], 'img' => $user['Slika'], 'name' => $user['Ime'] . ' ' . $user['Prezime'], 'type' => $user['Tip'], 'text' => $user['Opis']];
        }
        /**
         * Vraća status prijateljstva između korisnika userid i korisnika profid
         * Povratna vrednost requested znači da je userid poslao zahtev profid, a received da je profid poslao zahtev userid.
         * 
         * @param int $userid Ulogovani korisnik
         * @param int $profid Drugi korisnik
         * 
         * @return string
         */
        public function getFriendStatus($userid, $profid) {
            $ret = $this->db->table('jeprijatelj')->groupStart()->where(['idk1' => $userid, 'idk2' => $profid])->groupEnd()
                ->orGroupStart()->where(['idk1' => $profid, 'idk2' => $userid])->groupEnd()->get()->getResult();
            if (count($ret) > 0) return "friends";

            $ret = $this->db->table('zahtevzaprijateljstvo')->where(['idk1' => $userid, 'idk2' => $profid])->get()->getResult();
            if (count($ret) > 0) return "requested";

            $ret = $this->db->table('zahtevzaprijateljstvo')->where(['idk1' => $profid, 'idk2' => $userid])->get()->getResult();
            if (count($ret) > 0) return "received";

            return "none";
        }

        /**
         * Ažurira podatke na profilu korisnika userid.
         * 
         * @param int $userid ID korisnika
         * @param string $text Opis
         * @param string $img Slika (putanja)
         */
        public function updateProfile($userid, $text, $img) {
            $arr = ['opis' => $text];
            if ($img != null) $arr['slika'] = $img;
            return $this->update($userid, $arr);
        }


        /**
         * Dodaje zahtev za prijateljstvo od korisnika userid ka korisniku profid
         * 
         * @param int $userid Korisnik koji šalje zahtev
         * @param int $profid Korisnik koji prima zahtev
         * 
         * @return boolean
         */
        public function request($userid, $profid) {
            return $this->db->table('zahtevzaprijateljstvo')->insert(['idk1' => $userid, 'idk2' => $profid]);
        }

        /**
         * Briše zahtev za prijateljstvo od korisnika userid ka korisniku profid
         * 
         * @param int $userid Korisnik koji šalje zahtev
         * @param int $profid Korisnik koji prima zahtev
         * 
         * @return boolean
         */
        public function unrequest($userid, $profid) {
            return $this->db->table('zahtevzaprijateljstvo')->delete(['idk1' => $userid, 'idk2' => $profid]);
        }

        /**
         * Briše prijateljstvo korisnika userid i korisnika profid
         * 
         * @param int $userid Korisnik 1
         * @param int $profid Korisnik 2
         * 
         * @return boolean
         */
        public function unfriend($userid, $profid) {
            return $this->db->table('jeprijatelj')->groupStart()->where(['idk1' => $userid, 'idk2' => $profid])->groupEnd()
                ->orGroupStart()->where(['idk1' => $profid, 'idk2' => $userid])->groupEnd()->delete();
        }
        /**
         * Evidentira prijateljstvo korisnika userid i korisnika profid
         * 
         * @param int $userid Korisnik 1
         * @param int $profid Korisnik 2
         * 
         * @return boolean
         */
        public function accept($userid, $profid) {
            return $this->unrequest($profid, $userid) && $this->db->table('jeprijatelj')->insert(['idk1' => $userid, 'idk2' => $profid]);
        }
        
}