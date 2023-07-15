<?php
/*
    Autor: Aleksa Vučković 2020/0035
*/
namespace App\Controllers;

use App\Models\Korisnik;
use App\Models\ZahtevZaRegistraciju;

/**
 * Login - Kontroler za metode koje se mogu pozivati iz svih uloga (neregistrovani korisnik, registrovani korisnik, admin)
 */
class Login extends BaseController
{
    /**
     * Vraća stranicu za login/registraciju
     */
    public function index()
    {
        //vraca login stranicu;
        $data = ["register" => false, "success" => false];
        echo view('pages/login', $data);
        return;
    }
    /**
     * Obrađuje zahtev za login, pri čemu se parametri prosleđuju kao POST zahtev.
     * Ako su podaci ispravni, vraća feed stranicu i pamti korisnika u sesiji, u
     * suporotnom vraća login stranicu sa porukom o grešci.
     */
    public function login()
    {
        $data = ["register" => false, "success" => false];
        if (!$this->validate('login')) {
            $data['errors'] = $this->validator->getErrors();
            echo view('pages/login', $data);
            return;
        }
        else {
            $k = new Korisnik();
            $user = $k->getUser($this->request->getVar('logemail'));
            $user = $k->rename($user);
            $this->session->set('user', $user);
            return redirect()->to(site_url("User/feed"));
        }
    }

    /**
     * Obrađuje zahtev za registraciju, pri čemu se parametri prosleđuju kao POST zahtev.
     * Ako su podaci ispravni, pravi novi nalog i vraća login stranicu sa porukom o uspehu,
     * u suprotno vraća stranicu za registraciju sa porukom o grešci.
     */
    public function register()
    {
        if (!$this->validate('register')) {
            $data = ['register' => true, 'success' => false, 'errors' => $this->validator->getErrors()];
            echo view('pages/login', $data);
            return;
        }
        else {
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
