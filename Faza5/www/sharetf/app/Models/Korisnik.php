<?php namespace App\Models;

use CodeIgniter\Model;

class Korisnik extends Model
{
        protected $table      = 'korisnik';
        protected $primaryKey = 'idk';
        protected $returnType = 'array';
        protected $allowedFields = ['ime', 'prezime', 'email', 'lozinka', 'slika', 'opis', 'tip'];
        

        public function getUser($email) {
            return $this->where('email', $email)->first();
        }
        public function addUser($data, $type) {
            $data['tip'] = $type;
            return $this->insert($user);
        }
        public function updateUser($id, $fields) {
            return $this->update($id, $fields);
        }
        
}