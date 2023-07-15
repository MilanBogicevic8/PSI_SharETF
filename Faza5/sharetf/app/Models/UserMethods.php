<?php

namespace App\Models;

/**
* Bogicevic Milan 0284/2020
*/
class UserMethods{
    
    
    /**
     * Dohvata zahteve za prijateljstvo od korisnika.
     *
     * @param object $db Objekat baze podataka
     * @return array Niz zahteva za prijateljstvo
     */
    public function getFriendRequests($db,$data)
    {
        $res1 = $db->query("SELECT * FROM zahtevzaprijateljstvo WHERE IdK2 = ?", [(int) $data['user']['id']])->getResult();
        $requests = [];

        foreach ($res1 as $request) {
            $res2 = $db->query("SELECT * FROM korisnik WHERE IdK = ?", [$request->IdK1])->getResult();
            $requests[] = [
                "id" => $request->IdK1,
                "name" => $res2[0]->Ime . " " . $res2[0]->Prezime,
                "img" => $res2[0]->Slika,
                "text" => $res2[0]->Opis
            ];
        }

        return $requests;
    }
    
    /**
     * Proverava da li postoji zahtev za prijateljstvo između korisnika.
     *
     * @param object $db Objekat baze podataka
     * @param int $id ID korisnika
     * @return bool Da li postoji zahtev za prijateljstvo
     */
    public function checkFriendRequest($db, $id,$data)
    {
        $requestExists = $db->query("SELECT * FROM zahtevzaprijateljstvo WHERE IdK1 = ? AND IdK2 = ?", [(int) $id, (int) $data['user']['id']])->getResult();
        return count($requestExists) > 0;
    }
    
    
    /**
     * Dodaje prijateljstvo između korisnika.
     *
     * @param object $db Objekat baze podataka
     * @param int $id ID korisnika
     */
    public function addFriend($db, $id,$data)
    {
        $db->query("INSERT INTO jeprijatelj (IdK1, IdK2) VALUES (?, ?)", [(int) $id, (int) $data['user']['id']]);
    }
    
    
    /**
     * Briše zahtev za prijateljstvo između korisnika.
     *
     * @param object $db Objekat baze podataka
     * @param int $id ID korisnika
     */
    public function deleteFriendRequest($db, $id, $data)
    {
        $db->query("DELETE FROM zahtevzaprijateljstvo WHERE IdK1 = ? AND IdK2 = ?", [(int) $id, (int) $data['user']['id']]);
    }

    /**
     * Dohvata profile iz baze podataka koji odgovaraju datom terminu.
     *
     * @param object $db Objekat baze podataka
     * @param string $term Termin pretrage
     * @return array Niz profila
     */
    public function getProfilesFromDatabase($db, $term)
    {
        if ($term != "all") {
            $rez1 = $db->query("SELECT * FROM Korisnik WHERE concat(Ime, ' ', Prezime) LIKE ?", ["%" . $term . "%"])->getResult();
        } else {
            $rez1 = $db->query("SELECT * FROM Korisnik", [])->getResult();
        }
        return $rez1;
        /*
        if ($term != "all") {
            $rez1 = $db->query("SELECT * FROM Korisnik WHERE Ime LIKE ? OR Prezime LIKE ?", ["%" . $term . "%", "%" . $term . "%"])->getResult();
        } else {
            $rez1 = $db->query("SELECT * FROM Korisnik", [])->getResult();
        }
        return $rez1;
        */
    }
    
    /**
     * Dohvata grupe iz baze podataka koje odgovaraju datom terminu.
     *
     * @param object $db Objekat baze podataka
     * @param string $term Termin pretrage
     * @return array Niz grupa
     */
    public function getGroupsFromDatabase($db, $term)
    {
        if ($term != "all") {
            $rez1 = $db->query("SELECT * FROM grupa WHERE Naziv LIKE ?", ["%" . $term . "%"])->getResult();
        } else {
            $rez1 = $db->query("SELECT * FROM grupa")->getResult();
        }
        return $rez1;
    }
}
