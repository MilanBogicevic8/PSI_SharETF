<?php 

/*
    Autor: Aleksa Vučković 2020/0035
*/

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

/**
 * Grupa - Model za rad sa tabelom grupa, ali i tabelom jeclan
 */
class Grupa extends Model
{

        protected $table      = 'grupa';
        protected $primaryKey = 'idg';
        protected $returnType = 'array';
        protected $allowedFields = ['naziv', 'opis', 'slika'];
        

        /**
         * Vraća grupu id, uz broj članova
         * 
         * @param int $id ID grupe
         * 
         * @return array
         */
        public function getGroup($id) {
            $res = $this->db->table('grupa')->select('grupa.idg as id, grupa.slika as img, grupa.naziv as name, grupa.opis as text')
              ->join('jeclan', 'grupa.idg = jeclan.idg','left')
              ->selectCount('jeclan.idk', 'members')
              ->where('grupa.idg', $id)
              ->groupBy('grupa.idg')
              ->get()->getResult('array');
            if (count($res) == 0) return null;
            else return $res[0];
        }

        /**
         * Proverava da li je korisnik userid učlanjen u grupu id
         * 
         * @param int $id ID grupe
         * @param int $userid ID korisnika
         * 
         * @return boolean
         */
        public function joined($id, $userid) {
            $res = $this->db->table('jeclan')->where(['idg' => $id, 'idk' => $userid])->get()->getResult();
            return count($res) > 0;
        }
        /**
         * Učlanjuje korisnika userid u grupu id
         * 
         * @param int $id ID grupe
         * @param int $userid ID korisnika
         * 
         * @return boolean
         */
        public function join($id, $userid) {
            return $this->db->table('jeclan')->insert(['idg' => $id, 'idk' => $userid]);
        }

        /**
         * Išćlanjuje korisnika userid iz grupe id
         * 
         * @param int $id ID grupe
         * @param int $userid ID korisnika
         * 
         * @return boolean
         */
        public function unjoin($id, $userid) {
            return $this->db->table('jeclan')->delete(['idg' => $id, 'idk' => $userid]);
        }

        /**
         * Vraća sve grupe čiji je korisnik userid član
         * 
         * @param int $userid ID korisnika
         * 
         * @return array
         */
        public function getGroupsForProfile($userid) {
            return $this->db->table('grupa as g')->join('jeclan as j', 'g.idg = j.idg')
                ->select("g.idg as id, g.slika as img, g.naziv as 'name'")
                ->where('j.idk', $userid)->get()->getResult('array');
        }
        
}