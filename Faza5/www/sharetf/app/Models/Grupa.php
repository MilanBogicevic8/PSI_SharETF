<?php namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class Grupa extends Model
{
        protected $table      = 'grupa';
        protected $primaryKey = 'idg';
        protected $returnType = 'array';
        protected $allowedFields = ['naziv', 'opis', 'slika'];
        

        public function getGroup($id) {
            $conn = Database::getConnection();
            $query = "select g.idg as id, g.slika as img, g.naziv as name, g.opis as 'text', count(j.idk) as members
            from grupa g left join jeclan j on g.idg = j.idg
            where g.idg = ?
            group by g.idg";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $ret = Database::fetchResults($stmt);
            $conn->close();
            return $ret[0];
        }
        public function joined($id, $userid) {
            $conn = Database::getConnection();
            $query = "select * from jeclan where idg = ? and idk = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $id, $userid);
            $ret = Database::fetchResults($stmt);
            $conn->close();
            return count($ret) > 0;
        }
        public function join($id, $userid) {
            $conn = Database::getConnection();
            $query = "insert into jeclan(idg, idk) values(?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $id, $userid);
            $ret = $stmt->execute();
            $conn->close();
            return $ret;
        }
        public function unjoin($id, $userid) {
            $conn = Database::getConnection();
            $query = "delete from jeclan where idg = ? and idk = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $id, $userid);
            $ret = $stmt->execute();
            $conn->close();
            return $ret;
        }

        public function getGroupsForProfile($userid) {
            $conn = Database::getConnection();
            $query = "select g.idg as id, g.slika as img, g.naziv as 'name'
            from grupa g join jeclan j on g.idg = j.idg
            where idk = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userid);
            $ret = Database::fetchResults($stmt);
            $conn->close();
            return $ret;
        }
        
}