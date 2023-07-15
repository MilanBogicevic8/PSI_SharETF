<?php

/**
 * Autor: Bogicevic Milan 0284/2020
 */

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\Objava;

class ObjavaTest extends CIUnitTestCase
{
    protected $objavaModel;

    public function setUp(): void
    {
        parent::setUp();

        // Kreiranje instance modela Objava za testiranje
        $this->objavaModel = new Objava();
    }

    public function testGetFeedPosts()
    {
        // Simulacija podataka
        $lasttime = '2023-06-01 12:00:00';
        $userid = 1;

        // Pozivanje funkcije getFeedPosts() sa simuliranim podacima
        $result = $this->objavaModel->getFeedPosts($lasttime, $userid);

        // Provera rezultata
        $this->assertIsArray($result);
        $this->assertCount(11, $result);
    }

    public function testGetProfilePosts()
    {
        // Simulacija podataka
        $lasttime = '2023-06-01 12:00:00';
        $userid = 1;
        $profileid = 2;

        // Pozivanje funkcije getProfilePosts() sa simuliranim podacima
        $result = $this->objavaModel->getProfilePosts($lasttime, $userid, $profileid);

        // Provera rezultata
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
    }

    public function testGetGroupPosts()
    {
        // Simulacija podataka
        $lasttime = '2023-06-01 12:00:00';
        $userid = 1;
        $groupid = 3;

        // Pozivanje funkcije getGroupPosts() sa simuliranim podacima
        $result = $this->objavaModel->getGroupPosts($lasttime, $userid, $groupid);

        // Provera rezultata
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }
}

