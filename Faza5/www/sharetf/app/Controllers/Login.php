<?php

namespace App\Controllers;

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
            return redirect()->to(site_url("User/feed"));
        }
    }
    public function register()
    {
        //proverava sva polja za registraciju
        //ako je ok pamti u bazi
        //prikazuje odgovarajucu poruku
        $data = ["register" => false, "success" => false];
        if (!$this->validate('register')) {
            $data['errors'] = $this->validator->getErrors();
            $data['register'] = true;
            echo view('pages/login', $data);
            return;
        }
        else {
            //ovde treba evidentirati novog korisnika
            $data['success'] = true;
            echo view('pages/login', $data);
            return;
        }
    }
}
