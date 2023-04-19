<?php

namespace App\Controllers;
use App\Models\Post;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

include_once("TestData.php");

class User extends BaseController
{
    private $data = [];
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->data['user'] = $this->session->get('user');
    }
    public function feed()
    {
        //vraca feed za ulogovanog korisnika
        $this->showPage('feed', $this->data);
    }
    public function getPosts()
    {
        //vraca narednih 20 objava za ulogovanog korisnika, pocev od prosledjenog datuma unazad, u json formatu
        //postovi koji se vracaju zavise od stranice na kojoj se nalazi korisnik:
        //  1. Feed -> Svi relevantni (Grupe ciji je clan, Njegovi prijatelji)
        //  2. Group -> Samo iz te grupe
        //  3. Profil prijatelja -> Svi postovi tog korisnika
        //  4. Profil ne-prijatelja -> Samo grupni postovi tog korisnika
        //Zbog ovoga treba pamtiti u okviru sesije na kojoj je stranici korisnik, i za profilnu stranicu koji je id korisnika
        //U session['page'] cuva se stranica (feed, group, profile, myprofile), a u session['pageid'] id profila za stranicu profile, odnosno id grupe za stranicu grupe.
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
        /*echo var_dump($this->session->get());
        echo $lasttime;*/
        $lasttime = $this->request->getVar("lasttime");
        $p = new Post();
        $page = $this->session->get("page");
        $userid = $this->session->get("user")['id'];
        $pageid = $this->session->get("pageid");
        if ($page == 'feed') $posts = $p->getFeedPosts($lasttime, $userid);
        else if ($page == 'group' && $pageid != null) $posts = $p->getGroupPosts($lasttime, $userid, $pageid);
        else if (($page == 'profile' || $page == 'myprofile') && $pageid != null) $posts = $p->getProfilePosts($lasttime, $userid, $pageid);
        else $posts = [];
        echo json_encode($posts);
        return;
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
        if (!$this->validate('post')) $this->data['error'] = $this->combineErrors();
        else {
            //dodati post u bazu
        }
        $this->showPage('feed', $this->data);
        return;
    }

    public function group($id) {
        //vraca stranicu grupe id
        $this->data["group"] = TestData::$group;
        $this->data["joined"] = true;
        $this->session->set('pageid', $id);
        $this->showPage('group', $this->data);
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
        $this->data["group"] = TestData::$group;
        $this->data["joined"] = true;
        if (!$this->validate('post')) $this->data['error'] = $this->combineErrors();
        else {
            //dodati post u bazu
        }
        $this->showPage('group', $this->data);
        return;
    }

    public function profile($id) {
        //vraca profilnu stranicu
        //ako je id ulogovanog korisnika, onda vraca stranicu sa opcijom izmene profila
        $this->data["groups"] = [TestData::$group];
        $this->session->set('pageid', $id);
        $this->showPage('myprofile', $this->data);
        return;
    }
    public function updateProfile() {
        //azurira informacije profila ulogovanog korisnika
        //vraca stranicu profila sa azuriranim informacijama
        $this->data["groups"] = [TestData::$group];
        if (!$this->validate('myprofile'))  $this->data['error'] = $this->combineErrors();
        else {
            //evidentirati promene
        }
        $this->showPage('myprofile', $this->data);
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
        $this->data["post"] = TestData::$posts[0];
        $this->data['comments'] = TestData::$comments;
        $this->showPage('post', $this->data);
        return;
    }
    function addComment($id) {
        //dodaje komentar na post id, za ulogovanog korisnika
        //vraca stranicu sa azuriranim komentarima
        $this->data["post"] = TestData::$posts[0];
        $this->data['comments'] = TestData::$comments;
        if (!$this->validate('comment')) $this->data['error'] = $this->combineErrors();
        $this->showPage('post', $this->data);
    }

    function requests() {
        //prikazuje stranicu sa zahtevima za prijateljstvo za ulogovanog korisnika,
        $this->data["requests"] = TestData::$requests;
        $this->showPage('requests', $this->data);
        return;
    }
    function respond($id, $response) {
        //odgovara na zahtev za prijateljstvo od korisnika id u zavisnosti od response (yes ili no)
        return;
    }

    public function search() {
        $this->showPage('search', $this->data);
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