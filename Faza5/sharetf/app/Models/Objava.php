<?php 

/*
    Autor: Aleksa Vučković 2020/0035
*/

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

/**
 * Objava - Model za rad sa tabelom objava i ostalim povezanim tabelama
 */
class Objava extends Model
{
        protected $table      = 'objava';
        protected $primaryKey = 'idobj';
        protected $returnType = 'array';
        protected $allowedFields = ['tekst', 'slika', 'datumvreme', 'idk', 'idg'];
        
        /*
            {
                id: 1,
                text: "Objava",
                likenum: 1,
                liked: 0,
                commentnum: 1,
                img: "/uploads/slika.png",
                date: "1.1.2002. 12:00:00",
                userid: 1,
                username: "Ime Prezime",
                userimg: "/uploads/slika.png",
                groupid: 1,
                groupname: "Grupa" 
            }
        */
        /**
         * Vraća query builder upit zajednički za sva tri getPosts scenarija.
         * 
         * @param string $lasttime Datum počev od koga se dohvataju objave
         * @param int $userid ID korisnika za kog se dohvataju objave (ulogovani korisnik)
         */
        private function makeBaseQuery($userid, $lasttime) {
            return $this->db->table('objava as o')->join('korisnik as k', 'o.idk = k.idk')->join('grupa as g', 'o.idg = g.idg', 'left')
                ->select("o.idobj as id, o.tekst as 'text', likenum(o.idobj) as likenum, liked(o.idobj, $userid) as liked,
                commentnum(o.idobj) as commentnum, o.slika as img, o.datumvreme as 'date', o.idk as userid,
                CONCAT(k.ime, ' ', k.prezime) as username, k.slika as userimg, o.idg as groupid, g.naziv as groupname")
                ->where('o.datumvreme <', $lasttime)->orderBy('o.datumvreme', 'DESC')->limit(20);
        }

        /**
         * Vraća objave za stranicu feed
         * 
         * @param string $lasttime Datum počev od koga se dohvataju objave
         * @param int $userid ID korisnika za kog se dohvataju objave (ulogovani korisnik)
         * 
         * @return array
         */
        public function getFeedPosts($lasttime, $userid) {
            return $this->makeBaseQuery($userid, $lasttime)->groupStart()->where("arefriends(o.idk, $userid)")->orWhere("ismember(o.idg, $userid)")->groupEnd()->get()->getResult('array');
        }

        /**
         * Vraća objave za stranicu profile
         * 
         * @param string $lasttime Datum počev od koga se dohvataju objave
         * @param int $userid ID korisnika za kog se dohvataju objave (ulogovani korisnik)
         * @param string $profileid ID korisnika čije se objave dohvataju
         * 
         * @return array
         */
        public function getProfilePosts($lasttime, $userid, $profileid) {
            return $this->makeBaseQuery($userid, $lasttime)->where('o.idk', $profileid)->groupStart()
                ->where('o.idg is not null')->orWhere("arefriends($profileid, $userid)")->groupEnd()->get()->getResult('array');
        }

        /**
         * Vraća objave za stranicu group
         * 
         * @param string $lasttime Datum počev od koga se dohvataju objave
         * @param int $userid ID korisnika za kog se dohvataju objave (ulogovani korisnik)
         * @param string $groupid ID grupe čije se objave dohvataju
         * 
         * @return array
         */
        public function getGroupPosts($lasttime, $userid, $groupid) {
            return $this->makeBaseQuery($userid, $lasttime)->where('o.idg', $groupid)->get()->getResult('array');
        }

        /**
         * Dodaje objavu
         * 
         * @param string $text Tekst objave
         * @param string $img Putanja od slike ili null
         * @param string $date Datum objave
         * @param int $userid ID korisnika koji objavljuje
         * @param int $groupid ID grupe u kojoj se objavljuje
         */
        public function addPost($text, $img, $date, $userid, $groupid) {
            $post = [
                "tekst" => $text,
                "slika" => $img,
                "datumvreme" => $date,
                "idk" => $userid,
                "idg" => $groupid
            ];
            return $this->insert($post);
        }

        /**
         * Dodaje sliku objavi
         * 
         * @param int $id ID objave
         * @param string $img Nova putanja do slike
         * 
         * @return boolean
         */
        public function setImg($id, $img) {
            return $this->update($id, [
                'slika' => $img
            ]);
        }

        /**
         * Proverava da li je userid lajkovao objavu postid
         * 
         * @param int $userid ID korisnika
         * @param int $postid ID objave
         * 
         * @return boolean
         */
        public function liked($userid, $postid) {
            $res = $this->db->table('lajkovao')->where(['idk' => $userid, 'idobj' => $postid])->get()->getResult();
            return count($res) > 0;
        }
        /**
         * Dodaje lajk od korisnika userid na objavu postid
         * 
         * @param int $userid ID korisnika
         * @param int $postid ID objave
         * 
         * @return boolean
         */
        public function like($userid, $postid) {
            return $this->db->table('lajkovao')->insert(['idk' => $userid, 'idobj' => $postid]);
        }

        /**
         * Briše lajk od korisnika userid na objavu postid
         * 
         * @param int $userid ID korisnika
         * @param int $postid ID objave
         * 
         * @return boolean
         */
        public function unlike($userid, $postid) {
            return $this->db->table('lajkovao')->delete(['idk' => $userid, 'idobj' => $postid]);
        }
        
}