<?php

namespace App\Controllers;

include_once("TestData.php");

class Admin extends BaseController
{
    public function group()
    {
        //vraca stranicu admin-group
        $data = ["user" => TestData::$user, "success" => false];
        echo view("template/header", $data);
        echo view("pages/admin-group", $data);
        return;
    }
    public function addGroup() {
        //proverava polja i dodaje grupu za ulogovanog admina
        $data = ["user" => TestData::$user, "success" => false];
        if (!$this->validate('admingroup')) {
            $data['errors'] = $this->validator->getErrors();
            echo view("template/header", $data);
            echo view("pages/admin-group", $data);
            return;
        }
        else {
            $data['success'] = true;
            echo view("template/header", $data);
            echo view("pages/admin-group", $data);
            return;
        }
    }
    
    public static $regrequests = [
        [
            "id" => 5,
            "name" => "Janko Jankovic",
            "img" => "/uploads/prof3.png",
            "email" => "jj200035d@student.etf.bg.ac.rs"
        ],
        [
            "id" => 6,
            "name" => "Andjela Andjelic",
            "img" => "/uploads/prof5.png",
            "email" => "aa200035d@student.etf.bg.ac.rs"
        ]
    ];
    
    public function requests() {
        //vraca stranicu sa svim zahtevima za registraciju
        $db= \Config\Database::connect();
        
        //dohvatanje svih zahteva za registraciju
        $res1=$db->query("select * from zahtevzaregistraciju")->getResult();
        
        $count=count($res1);
        
        $reqrequests=[];
        
        for($i=0;$i<$count;$i++){
            $reqrequests[]=["id"=>$res1[$i]->IdZah,"name"=>$res1[$i]->Ime." ".$res1[$i]->Prezime,"img"=>$res1[$i]->Slika,"email"=>$res1[$i]->Email];   
        }
        
        $data = ["user" => $this->session->get("user"), "requests" => $reqrequests];
        echo view("template/header", $data);
        echo view("pages/admin-requests", $data);
        return;
    }
    public function respond($id, $response) {
        //odgovara na zahtev id u zavisnosti od response (yes ili no)
        //vraca poruku o uspehu
        
        $db= \Config\Database::connect();
        if($response=="yes"){
            $res1=$db->query("select * from zahtevzaregistraciju where IdZah=?",[(int)$id])->getResult();
            var_dump($res1);
            $db->query("insert into korisnik(Ime,Prezime,Email,Lozinka,Slika,Tip) values(?,?,?,?,?,?)",[$res1[0]->Ime,$res1[0]->Prezime,$res1[0]->Email,$res1[0]->Lozinka,$res1[0]->Slika,'R']);
            $db->query("delete from zahtevzaregistraciju where idzah=?",[$id]);
            return "Uspesno";
        }else{
            $db->query("delete from zahtevzaregistraciju where idzah=?",[$id]);
            return "Ne uspesno";
        }
    }
}