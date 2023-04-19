<?php namespace App\Models;

use CodeIgniter\Model;

class ZahtevZaRegistraciju extends Model
{
        protected $table      = 'zahtevzaregistraciju';
        protected $primaryKey = 'idzah';
        protected $returnType = 'array';
        protected $allowedFields = ['ime', 'prezime', 'email', 'lozinka', 'slika', 'tip'];
        

        public function removeRequest($id) {
            $ret = $this->find($id);
            $this->delete($id);
            return $ret;
        }
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
        public function setImg($id, $img) {
            return $this->update($id, [
                'slika' => $img
            ]);
        }
        public function exists($email) {
            return $this->where('email', $email)->first() != null;
        }
        
}