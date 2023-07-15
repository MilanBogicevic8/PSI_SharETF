<?php

/*
* Autor: Aleksa Vučković, 2020/0035
*/
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\AdminMethods;
use App\Models\Korisnik;
use App\Models\ZahtevZaRegistraciju;


class AdminMethodsTest extends CIUnitTestCase
{
    public function test()
    {
        $db = \Config\Database::connect();
        $am = new AdminMethods();
        $k = new Korisnik();
        $zz = new ZahtevZaRegistraciju();

        $correctName = "Ranko";
        $correctMail = "rr200000d@student.etf.bg.ac.rs";

        $result = $am->getAllRegistrationRequests($db);
        $this->assertEquals(count($result), 1);
        $result = $result[0];
        $this->assertEquals($result->Ime, $correctName);
        $this->assertEquals($result->Email, $correctMail);
        
       $result = $am->getRegistrationRequestById($db, 5);
       $this->assertNull($result);

       $result = $am->getRegistrationRequestById($db, 1);
       $this->assertEquals($result->Ime, $correctName);
       $this->assertEquals($result->Email, $correctMail);

       $am->createUserFromRegistrationRequest($db, $result);
       $result = $k->getUser($correctMail);
       $this->assertNotNull($result);
       $this->assertEquals($result['Email'], $correctMail);
       $this->assertEquals($result['Ime'], $correctName);

       $am->deleteRegistrationRequest($db, 1);
       $result = $zz->find(1);
       $this->assertNull($result);
    }
}
