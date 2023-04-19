<?php

namespace App\Controllers;

include_once("TestData.php");

class User extends BaseController
{
    public function feed()
    {
        $data = ["user" => TestData::$user];
        //vraca feed za ulogovanog korisnika
        $this->showPage('feed', $data);
    }
    public function getPosts($datetime)
    {
        //vraca narednih 20 objava za ulogovanog korisnika, pocev od prosledjenog datuma unazad, u json formatu
        //postovi koji se vracaju zavise od stranice na kojoj se nalazi korisnik:
        //  1. Feed -> Svi relevantni (Grupe ciji je clan, Njegovi prijatelji)
        //  2. Group -> Samo iz te grupe
        //  3. Profil prijatelja -> Svi postovi tog korisnika
        //  4. Profil ne-prijatelja -> Samo grupni postovi tog korisnika
        //Zbog ovoga treba pamtiti u okviru sesije na kojoj je stranici korisnik, i za profilnu stranicu koji je id korisnika
        //Na taj nacin ce se na svim stranicama na front-endu uniformno implementirati dinamicko ucitavanje postova
        /* format u kom se vracaju postovi je sledeci:
            {
                id: 1,
                text: "Objava",
                likenum: 1,
                liked: 0,
                commentnum: 1,
                img: "/uploads/slika.png",
                date: "1.1.2002. 12:00:00",
                userid: 1,
                username: "Ime Prezime",
                userimg: "/uploads/slika.png",
                groupid: 1,
                groupname: "Grupa" 
            }
        groupid i groupname postoje samo za grupne postove, a img samo za postove sa slikom. Vraca se niz od maksimalno 20 ovakvih objekata
        polje liked = 0 znaci da ulogovani korisnik nije lajkova post, a 1 da jeste*/
        echo json_encode(TestData::$posts);
    }
    public function like($id)
    {
        //lajkuje ili brise lajk za post sa id-em id, za ulogovanog korisnika.
        //  1. Ako je post lajkovan vraca "liked"
        //  2. Ako je post unlikeovan vraca "unliked"
        echo "liked";
        return;
    }
    public function privatePost()
    {
        //proverava polja i evidentira novu objavu
        //vraca stranicu feed
        $data = ['user' => TestData::$user];
        if (!$this->validate('post')) $data['error'] = $this->combineErrors();
        else {
            //dodati post u bazu
        }
        $this->showPage('feed', $data);
        return;
    }

    public function group($id) {
        //vraca stranicu grupe id
        $data = ["user" => TestData::$user, "group" => TestData::$group, "joined" => true];
        $this->showPage('group', $data);
        return;
    }
    public function joinGroup($id) {
        //uclanjuje/iscalnjuje ulogovanog korisnika iz grupe id
        //  1. Ako je korisnik uclanjen, izbacuje ga
        //  2. Ako korisnik nije uclanjen, uclanjuje ga
        //vraca strnaicu group
        return redirect()->to(site_url("User/group/$id"));
    }
    public function groupPost($id) {
        //proverava polja i evidentira novu objavu u grupi id
        //vraca stranicu group
        $data = ["user" => TestData::$user, "group" => TestData::$group, "joined" => true];
        if (!$this->validate('post')) $data['error'] = $this->combineErrors();
        else {
            //dodati post u bazu
        }
        $this->showPage('group', $data);
        return;
    }

    public function profile($id) {
        //vraca profilnu stranicu
        //ako je id ulogovanog korisnika, onda vraca stranicu sa opcijom izmene profila
        $data = ["user" => TestData::$user, "groups" => [TestData::$group]];
        $this->showPage('myprofile', $data);
        return;
    }
    public function updateProfile() {
        //azurira informacije profila ulogovanog korisnika
        //vraca stranicu profila sa azuriranim informacijama
        $data = ["user" => TestData::$user, "groups" => [TestData::$group]];
        if (!$this->validate('myprofile'))  $data['error'] = $this->combineErrors();
        else {
            //evidentirati promene
        }
        $this->showPage('myprofile', $data);
        return;
    }
    public function sendRequest($id) {
        //salje zahtev za prijateljstvo od ulogovanog korisnika ka korisniku id
        //postoji vise mogucnosti
        //  1. Ako je zahtev vec poslat, opoziva se
        //  2. Ako je korisnik id vec poslao zahtev ulogovanom korisniku, prijateljstvo se evidentira
        //  3. Ako je korisnik vec prijatelj, brise se prijateljstvo
        //  4. U suprotnom zahtev se evidentira
        //vraca stranicu istog profila sa azuriranim podacima
        return redirect()->to(site_url("User/profile/1"));
    }

    function comments($id) {
        //prikazuje stranicu sa komentarima za post id
        //proverava i da li ulogovani korisnik ima pravo pristupa do te objave (nema ako je privatna a autor nije prijatelj ulogovanog korisnika)
        $data = [
            "user" => TestData::$user,
            "post" => TestData::$posts[0],
            "comments" => TestData::$comments
        ];
        $this->showPage('post', $data);
        return;
    }
    function addComment($id) {
        //dodaje komentar na post id, za ulogovanog korisnika
        //vraca stranicu sa azuriranim komentarima
        $data = [
            "user" => TestData::$user,
            "post" => TestData::$posts[0],
            "comments" => TestData::$comments
        ];
        if (!$this->validate('comment')) $data['error'] = $this->combineErrors();
        $this->showPage('post', $data);
    }

    function requests() {
        //prikazuje stranicu sa zahtevima za prijateljstvo za ulogovanog korisnika,
        $data = ["user" => TestData::$user, "requests" => TestData::$requests];
        $this->showPage('requests', $data);
        return;
    }
    function respond($id, $response) {
        //odgovara na zahtev za prijateljstvo od korisnika id u zavisnosti od response (yes ili no)
        return;
    }

    public function search() {
        $data = ["user" => TestData::$user];
        $this->showPage('search', $data);
    }
    public function getSearchResults($term, $type) {
        //vraca json listu rezultata pretrage
        //specijalna vrednost za term je "all", i oznacava prikaz svih profila/grupa
        //type je "profile" ili "group"
        //ovde bi mozda trebalo omoguciti paginaciju rezultata
        //format:
        /*
            {
                id: 1,
                img: "/uploads/...",
                name: "Ime",
                text: "Opis"
            }
        */
        echo json_encode(TestData::$requests);
        return;
    }

    public function logout() {
        //brise session
        //vraca na login stranicu
        return redirect()->to(site_url("Login/index"));
    }

    private function combineErrors() {
        $errors = $this->validator->getErrors();
        $msg = "";
        foreach($errors as $error) $msg .= $error . "</br>";
        return $msg;
    }
}