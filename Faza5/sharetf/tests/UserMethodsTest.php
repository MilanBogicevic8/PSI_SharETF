<?php
/*
* Autor: Aleksa Vučković, 2020/0035
*/
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\UserMethods;
use App\Models\Korisnik;


class UserMethodsTest extends CIUnitTestCase
{
    public function testFriendRequests1()
    {
        $db = \Config\Database::connect();

        $correct = [ ["id" => 3, "name" => "Petar Petrović", "img" => "/uploads/prof1.png", "text" => "Ja sam Petar i treća sam godina na SI."],
        ["id" => 6, "name" => "Jana Janić", "img" => "/uploads/prof6.png", "text" => "Ja sam Jana i treća sam godina na SI. Iz Beograda sam i imam 22 godine. Volim da putujem i da se družim. Omiljeno jelo mi je sarajevski ćevap."]];

        $um = new UserMethods();
        $result = $um->getFriendRequests($db, ['user' => ['id' => 5] ]);
        
        $this->assertEquals($correct, $result);
    }

    public function testFriendRequests2()
    {
        $db = \Config\Database::connect();
        $um = new UserMethods();
        $k = new Korisnik();

        $result = $um->checkFriendRequest($db, 3, ['user' => ['id' => 4]]);
        $this->assertTrue($result);

        $result = $um->checkFriendRequest($db, 3, ['user' => ['id' => 2]]);
        $this->assertFalse($result);

        $um->deleteFriendRequest($db, 3, ['user' => ['id' => 4]]);
        $um->addFriend($db, 3, ['user' => ['id' => 4]]);
        $result = $k->getFriendStatus(3, 4);
        $this->assertEquals($result, "friends");
    }

    public function testProfiles()
    {
        $db = \Config\Database::connect();
        $um = new UserMethods();
        $result = $um->getProfilesFromDatabase($db, "all");
        $this->assertEquals(count($result), 6);

        $result = $um->getProfilesFromDatabase($db, "jana jan")[0];
        $this->assertEquals($result->IdK, 6);
        $this->assertEquals($result->Ime, "Jana");
        $this->assertEquals($result->Email, "jj200000d@student.etf.bg.ac.rs");
        
        $result = $um->getProfilesFromDatabase($db, 'an');
        $this->assertEquals(count($result), 4);
    }

    public function testGroups()
    {
        $db = \Config\Database::connect();
        $um = new UserMethods();

        $result = $um->getGroupsFromDatabase($db, "all");
        $this->assertEquals(count($result), 3);

        $result = $um->getGroupsFromDatabase($db, "etf")[0];
        $this->assertEquals($result->IdG, 1);
        $this->assertEquals($result->Naziv, "ETF");

        $result = $um->getGroupsFromDatabase($db, "13S113");
        $this->assertEquals(count($result), 2);
    }
}
