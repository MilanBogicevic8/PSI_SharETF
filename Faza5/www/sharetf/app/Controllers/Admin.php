<?php

namespace App\Controllers;

include_once("TestData.php");

class Admin extends BaseController
{
    public function group()
    {
        //vraca stranicu admin-group
        $data = ["user" => TestData::$user];
        echo view("template/header", $data);
        echo view("pages/admin-group", $data);
        return;
    }
    public function addGroup() {
        //proverava polja i dodaje grupu za ulogovanog admina
        return redirect()->to(site_url("Admin/group"));
    }
    public function requests() {
        //vraca stranicu sa svim zahtevima za registraciju
        $data = ["user" => TestData::$user, "requests" => TestData::$regrequests];
        echo view("template/header", $data);
        echo view("pages/admin-requests", $data);
        return;
    }
    public function respond($id, $response) {
        //odgovara na zahtev id u zavisnosti od response (yes ili no)
        //vraca poruku o uspehu
        return;
    }
}