<?php namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

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
        private $queryStart = "select o.idobj as id,  o.tekst as 'text', likenum(o.idobj) as likenum, liked(o.idobj, ?) as liked,
        commentnum(o.idobj) as commentnum, o.slika as img, o.datumvreme as 'date', o.idk as userid,
        CONCAT(k.ime, ' ', k.prezime) as username, k.slika as userimg, o.idg as groupid, g.naziv as groupname
        from objava o join korisnik k on o.idk = k.idk left join grupa g on o.idg = g.idg
        where o.datumvreme < ?";
        private $queryEnd = "
        order by o.datumvreme desc
        limit 20";
        private function makeQuery($condition) {
            return $this->queryStart . "
            and (" . $condition . ")" . $this->queryEnd;
        }
        private function feedQuery() {//userid, lasttime, userid, userid
            return $this->makeQuery("arefriends(o.idk, ?) or ismember(o.idg, ?)");
        }
        private function profileQuery() {//userid, lasttime, profileid, profileid, userid
            return $this->makeQuery("o.idk = ? and (o.idg is not null or arefriends(?, ?))");
        }
        private function groupQuery() {//userid, lasttime, groupid
            return $this->makeQuery("o.idg = ?");
        }
        private function getConnection() {
            $db = new Database();
            return new \mysqli($db->default['hostname'], $db->default['username'], $db->default['password'], $db->default['database']);
        }
        private function fetchResults($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $ret = [];
            while (true) {
                $t = $result->fetch_array();
                if ($t == null) break;
                $ret[] = $t;
            }
            $result->free();
            return $ret;
        }
        public function getFeedPosts($lasttime, $userid) {
            $query = $this->feedQuery();
            $conn = $this->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isii", $userid, $lasttime, $userid, $userid);
            $ret = $this->fetchResults($stmt);
            $conn->close();
            return $ret;
        }
        public function getProfilePosts($lasttime, $userid, $profileid) {
            $query = $this->profileQuery();
            $conn = $this->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isiii", $userid, $lasttime, $profileid, $profileid, $userid);
            $ret = $this->fetchResults($stmt);
            $conn->close();
            return $ret;
        }
        public function getGroupPosts($lasttime, $userid, $groupid) {
            $query = $this->groupQuery();
            $conn = $this->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isi", $userid, $lasttime, $groupid);
            $ret = $this->fetchResults($stmt);
            $conn->close();
            return $ret;
        }

        //dodavanje posta
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

        public function setImg($id, $img) {
            return $this->update($id, [
                'slika' => $img
            ]);
        }

        //lajkovi
        public function liked($userid, $postid) {
            $conn = $this->getConnection();
            $query = "select * from lajkovao where idk = ? and idobj = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userid, $postid);
            $results = $this->fetchResults($stmt);
            $ret = count($results) > 0;
            $conn->close();
            return $ret;
        }
        public function like($userid, $postid) {
            $conn = $this->getConnection();
            $query = "insert into lajkovao(idk, idobj) values(?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userid, $postid);
            $ret = $stmt->execute();
            $conn->close();
            return $ret;
        }
        public function unlike($userid, $postid) {
            $conn = $this->getConnection();
            $query = "delete from lajkovao where idk = ? and idobj = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $userid, $postid);
            $ret = $stmt->execute();
            $conn->close();
            return $ret;
        }
        
}