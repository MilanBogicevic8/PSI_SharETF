<?php

namespace App\Controllers;

include_once("TestData.php");

class Admin extends BaseController
{
    public function group()
    {
        //vraca stranicu admin-group
        
        $data = ["user" => $this->session->get("user"), "success" => false];
        echo view("template/header", $data);
        echo view("pages/admin-group", $data);
        return;
    }
    
    
    public function addGroup() {
        
        //var_dump($_REQUEST);
        //proverava polja i dodaje grupu za ulogovanog admina
        $data = ["user" => $this->session->get('user'), "success" => false];
        if (!$this->validate('admingroup')) {
            $data['errors'] = $this->validator->getErrors();
            echo view("template/header", $data);
            echo view("pages/admin-group", $data);
            return;
        }
        else {
            $name=$this->request->getVar("name");
            $text=$this->request->getVar("text");
            
            $db= \Config\Database::connect();
            //echo $_FILES['img']['name'];
            $file = $this->request->getFile('img');
            $db->query("insert into grupa(Naziv,Opis) values(?,?)",[$name,$text]);
            if ($file->isValid()) {
                $id=$db->query("SELECT max(IdG) as max from grupa")->getResult();
                echo $id[0]->max;
                $img = 'grupa-' . $id[0]->max . '.' . $file->getClientExtension();
                $file->move(ROOT_DIR . UPLOAD_DIR, $img);
                $img = UPLOAD_DIR . "/" . $img;
                echo $img;
                $db->query("update grupa g set g.Slika=? where g.IdG=?",[$img,$id[0]->max]);
            }
              
            $data['success'] = true;
            echo view("template/header", $data);
            echo view("pages/admin-group", $data);
            return;
        }
    }
    
    
    
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
        
        $daLiJePrazno=$db->query("select * from zahtevzaregistraciju where IdZah=?",[(int)$id])->getResult();
        if(count($daLiJePrazno)==0) {return redirect()->to (site_url ("User/requests"));}
       
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