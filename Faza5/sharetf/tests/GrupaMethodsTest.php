<?php

/*
* Autor: Bogicevic Milan, 2020/0284
*/
use CodeIgniter\Test\CIUnitTestCase;
use App\Models\Grupa;

class GrupaMethodsTest extends CIUnitTestCase
{
    protected $refresh = true;

    public function testGetGroup()
    {
        $model = new Grupa();

        // Testiranje postojeće grupe
        $group = $model->getGroup(1);
        $this->assertEquals(1, $group['id']);
        $this->assertEquals('/uploads/etf.jpg', $group['img']);
        $this->assertEquals('ETF', $group['name']);
        $this->assertEquals('Grupa za sve studente ETF-a, za teme u vezi sa upisom, studijama, prijavi ispita i dr. Pitanja u vezi sa pojedinim predmetima postavite u odgovarajućoj grupi, ne ovde!', $group['text']);
        $this->assertEquals(4, $group['members']);

    }

    public function testJoined()
    {
        $model = new Grupa();

        // Testiranje slučaja kada je korisnik učlanjen
        $joined = $model->joined(1, 1);
        $this->assertTrue($joined);

        // Testiranje slučaja kada korisnik nije učlanjen
        $joined = $model->joined(1, 2);
        $this->assertTrue($joined);
    }

    public function testGetGroupsForProfile()
    {
        $model = new Grupa();

        // Testiranje korisnika koji je član grupa
        $groups = $model->getGroupsForProfile(1);
        $this->assertCount(3, $groups);
        $this->assertEquals(1, $groups[0]['id']);
        $this->assertEquals('/uploads/etf.jpg', $groups[0]['img']);

        $this->assertEquals(2, $groups[1]['id']);
        $this->assertEquals('/uploads/group2.png', $groups[1]['img']);
        $this->assertEquals('Sistemski Softver (13S113SS)', $groups[1]['name']);

    }
}
