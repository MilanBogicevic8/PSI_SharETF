<?php namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class Korisnik extends Model
{
        protected $table      = 'korisnik';
        protected $primaryKey = 'idk';
        protected $returnType = 'array';
        protected $allowedFields = ['ime', 'prezime', 'email', 'lozinka', 'slika', 'opis', 'tip'];
        

        public function getUser($email) {
            $ret = $this->where('email', $email)->first();
            return $ret;
        }
        public function getUserById($id) {
            $ret = $this->find($id);
            return $ret;
        }
        public function rename($user) {
            return ['id' => (int)$user['IdK'], 'img' => $user['Slika'], 'name' => $user['Ime'] . ' ' . $user['Prezime'], 'type' => $user['Tip'], 'text' => $user['Opis']];
        }
        public function getFriendStatus($userid, $profid) {
            $conn = Database::getConnection();
            $query = "select * from jeprijatelj where idk1 = ? and idk2 = ? or idk1 = ? and idk2 = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiii", $profid, $userid, $userid, $profid);
            $ret = Database::fetchResults($stmt);
            if (count($ret) > 0) { $conn->close(); return "friends"; }

            $query = "select * from zahtevzaprijateljstvo where idk1 = ? and idk2 = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userid, $profid);
            $ret = Database::fetchResults($stmt);
            if (count($ret) > 0) { $conn->close(); return "requested"; }

            $query = "select * from zahtevzaprijateljstvo where idk1 = ? and idk2 = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $profid, $userid);
            $ret = Database::fetchResults($stmt);
            if (count($ret) > 0) { $conn->close(); return "received"; }

            $conn->close();
            return "none";
        }
        public function updateProfile($userid, $text, $img) {
            $arr = ['opis' => $text];
            if ($img != null) $arr['slika'] = $img;
            return $this->update($userid, $arr);
        }
        public function addUserFromRequest($data, $type) {
            $data['tip'] = $type;
            return $this->insert($user);
        }

        //prijateljstva
        public function request($userid, $profid) {
            $conn = Database::getConnection();
            $query = "insert into zahtevzaprijateljstvo(idk1, idk2) values(?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userid, $profid);
            $ret = $stmt->execute();
            $conn->close();
            return $ret;
        }
        public function unrequest($userid, $profid) {
            $conn = Database::getConnection();
            $query = "delete from zahtevzaprijateljstvo where idk1 = ? and idk2 = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userid, $profid);
            $ret = $stmt->execute();
            $conn->close();
            return $ret;
        }
        public function unfriend($userid, $profid) {
            $conn = Database::getConnection();
            $query = "delete from jeprijatelj where idk1 = ? and idk2 = ? or idk1 = ? and idk2 = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiii", $profid, $userid, $userid, $profid);
            $ret = $stmt->execute();
            $conn->close();
            return $ret;
        }
        public function accept($userid, $profid) {
            $this->unrequest($profid, $userid);
            $conn = Database::getConnection();
            $query = "insert into jeprijatelj(idk1, idk2) values(?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userid, $profid);
            $ret = $stmt->execute();
            $conn->close();
            return $ret;
        }
        
}