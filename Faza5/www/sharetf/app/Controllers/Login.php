<?php

namespace App\Controllers;

use App\Models\Korisnik;
use App\Models\ZahtevZaRegistraciju;

class Login extends BaseController
{
    public function index()
    {
        //vraca login stranicu;
        $data = ["register" => false, "success" => false];
        echo view('pages/login', $data);
        return;
    }
    public function login()
    {
        //proverava korisnicko ime i lozinku
        //ako je ok prelazi na feed, u suprotnom prikazuje odgovarajucu poruku
        $data = ["register" => false, "success" => false];
        if (!$this->validate('login')) {
            $data['errors'] = $this->validator->getErrors();
            echo view('pages/login', $data);
            return;
        }
        else {
            //ovde treba u sesiji zapamtiti ulogovanog korisnika
            $k = new Korisnik();
            $user = $k->getUser($this->request->getVar('logemail'));
            $user = $k->rename($user);
            $this->session->set('user', $user);
            return redirect()->to(site_url("User/feed"));
        }
    }
    public function register()
    {
        //proverava sva polja za registraciju
        //ako je ok pamti u bazi
        //prikazuje odgovarajucu poruku
        if (!$this->validate('register')) {
            $data = ['register' => true, 'success' => false, 'errors' => $this->validator->getErrors()];
            echo view('pages/login', $data);
            return;
        }
        else {
            //ovde treba evidentirati novog korisnika
            $z = new ZahtevZaRegistraciju();
            $id = $z->addRequest($this->request->getVar('name'), $this->request->getVar('lastname'), $this->request->getVar('email'), $this->request->getVar('password'), 'tmp');
            $file = $this->request->getFile('img');
            if ($file->isValid()) {
                $img = 'zahtev-' . $id . '.' . $file->getClientExtension();
                $file->move(ROOT_DIR . UPLOAD_DIR, $img);
                $img = UPLOAD_DIR . "/" . $img;
            } else $img = DEFAULT_PROF;
            $z->setImg($id, $img);
            $data = ['register' => false, 'success' => true];
            echo view('pages/login', $data);
            return;
        }
    }
}
