<?php

/**
 * 
 * Autor: Bogicevic Milan 0284/2020
 */

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\Korisnik;

class KorisnikMethodsTest extends CIUnitTestCase
{
    protected $korisnikModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->korisnikModel = new \App\Models\Korisnik();
    }

    public function testGetUser()
    {
        // Testiranje da li se dobija niz kada postoji korisnik sa zadatom email adresom
        $email = 'korisnik1@example.com';
        $user = $this->korisnikModel->getUser($email);
        $this->assertNull($user);

    }

    public function testGetUserById()
    {
        // Testiranje da li se dobija niz kada postoji korisnik sa zadatim ID-em
        $id = 1;
        $user = $this->korisnikModel->getUserById($id);
        $this->assertIsArray($user);

        // Testiranje da li se dobija null kada ne postoji korisnik sa zadatim ID-em
        $id = 999;
        $user = $this->korisnikModel->getUserById($id);
        $this->assertNull($user);
    }

    public function testRename()
    {
        // Testiranje da li se dobija niz sa preimenovanim poljima
        $user = ['IdK' => 1, 'Slika' => 'slika.jpg', 'Ime' => 'John', 'Prezime' => 'Doe', 'Tip' => 'admin', 'Opis' => 'Opis korisnika'];
        $renamedUser = $this->korisnikModel->rename($user);
        $this->assertIsArray($renamedUser);
        $this->assertArrayHasKey('id', $renamedUser);
        $this->assertArrayHasKey('img', $renamedUser);
        $this->assertArrayHasKey('name', $renamedUser);
        $this->assertArrayHasKey('type', $renamedUser);
        $this->assertArrayHasKey('text', $renamedUser);
    }

    public function testUpdateProfile()
    {
        // Testiranje ažuriranja podataka na profilu korisnika
        $userid = 1;
        $text = 'Novi opis';
        $img = 'nova_slika.jpg';
        $result = $this->korisnikModel->updateProfile($userid, $text, $img);
        $this->assertTrue($result);
    }

    public function testRequest()
    {
        // Testiranje slanja zahteva za prijateljstvo
        $userid = 1;
        $profid = 2;
        $result = $this->korisnikModel->request($userid, $profid);
        $this->assertTrue($result);
    }

    public function testUnrequest()
    {
        // Testiranje brisanja zahteva za prijateljstvo
        $userid = 1;
        $profid = 2;
        $result = $this->korisnikModel->unrequest($userid, $profid);
        $this->assertTrue($result);
    }

    public function testUnfriend()
    {
        // Testiranje brisanja prijateljstva
        $userid = 1;
        $profid = 2;
        $result = $this->korisnikModel->unfriend($userid, $profid);
        $this->assertTrue($result);
    }

    public function testAccept()
    {
        // Testiranje prihvatanja zahteva za prijateljstvo
        $userid = 1;
        $profid = 2;
        $result = $this->korisnikModel->accept($userid, $profid);
        $this->assertTrue($result);
    }


     
}
