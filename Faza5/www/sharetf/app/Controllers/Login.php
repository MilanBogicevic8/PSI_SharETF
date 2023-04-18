<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        //vraca login stranicu;
        echo view('pages/login');
        return;
    }
    public function login()
    {
        //proverava korisnicko ime i lozinku
        //ako je ok prelazi na feed, u suprotnom prikazuje odgovarajucu poruku

        return redirect()->to(site_url("User/feed"));
    }
    public function register()
    {
        //proverava sva polja za registraciju
        //ako je ok pamti u bazi
        //prikazuje odgovarajucu poruku
        return redirect()->to(site_url("Login/login"));
    }
}
