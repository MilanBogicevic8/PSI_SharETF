<?php
/*
    Autori: Bogićević Milan 2020/0284

 */
namespace App\Controllers;

//include_once("TestData.php");

use App\Models\AdminMethods;


class Admin extends BaseController
{
    
    
    
    
    /**
     * vraca stranicu admin-group
     *
     * 
     */
    
    
    public function group()
    {
        
        $data = ["user" => $this->session->get("user"), "success" => false];
        $this->showPage('admin-group', $data);
        return;
    }
    
    /**
     * proverava polja i dodaje grupu za ulogovanog admina
     * @return type
     */
    public function addGroup() {


        $data = ["user" => $this->session->get('user'), "success" => false];
        if (!$this->validate('admingroup')) {
            $data['errors'] = $this->validator->getErrors();
            $this->showPage('admin-group', $data);
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
                $img = 'grupa-' . $id[0]->max . '.' . $file->getClientExtension();
                $file->move(ROOT_DIR . UPLOAD_DIR, $img);
                $img = UPLOAD_DIR . "/" . $img;
                $db->query("update grupa g set g.Slika=? where g.IdG=?",[$img,$id[0]->max]);
            }

            $data['success'] = true;
            $this->showPage('admin-group', $data);
        }
    }

        /**
            * Vraća stranicu sa svim zahtevima za registraciju.
        */
        public function requests() {
            $adm=new AdminMethods();
            $db = $adm->getDatabaseConnection();
            $res1 = $adm->getAllRegistrationRequests($db);

            $reqrequests = [];
            foreach ($res1 as $row) {
                $reqrequests[] = [
                    "id" => $row->IdZah,
                    "name" => $row->Ime . " " . $row->Prezime,
                    "img" => $row->Slika,
                    "email" => $row->Email
                ];
            }

            $data = [
                "user" => $this->session->get("user"),
                "requests" => $reqrequests
            ];
            $this->showPage('admin-requests', $data);
            return;
        }

        /**
         * Odgovara na zahtev za registraciju.
         * 
         * @param int $id ID zahteva
         * @param string $response Odgovor (yes ili no)
         * @return string Poruka o uspehu
         */
        public function respond($id, $response) {
            $adm=new AdminMethods();
            $db = $adm->getDatabaseConnection();
            $registrationRequest = $adm->getRegistrationRequestById($db, $id);

            if (empty($registrationRequest)) {
                return redirect()->to(site_url("User/requests"));
            }

            if ($response == "yes") {
                $adm->createUserFromRegistrationRequest($db, $registrationRequest);
            }

            $adm->deleteRegistrationRequest($db, $id);

            return $response == "yes" ? "Uspesno" : "Ne uspesno";
        }
         
}