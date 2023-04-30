<?php

namespace App\Controllers;
use App\Models\Objava;
use App\Models\Grupa;
use App\Models\Korisnik;
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
        $o = new Objava();
        $page = $this->session->get("page");
        $userid = $this->session->get("user")['id'];
        $pageid = $this->session->get("pageid");
        if ($page == 'feed') $posts = $o->getFeedPosts($lasttime, $userid);
        else if ($page == 'group' && $pageid != null) $posts = $o->getGroupPosts($lasttime, $userid, $pageid);
        else if (($page == 'profile' || $page == 'myprofile') && $pageid != null) $posts = $o->getProfilePosts($lasttime, $userid, $pageid);
        else $posts = [];
        echo json_encode($posts);
        return;
    }
    public function like($postid)
    {
        //lajkuje ili brise lajk za post sa id-em postid, za ulogovanog korisnika.
        //  1. Ako je post lajkovan vraca "liked"
        //  2. Ako je post unlikeovan vraca "unliked"
        $userid = $this->data['user']['id'];
        $postid = (int)$postid;

        //mozda bi trebalo dodati i proveru, ako je objava privatna, da li su korisnici prijatelji?
        //iako korisnik nikako ne moze da vidi privatne objave korisnika koji mu nisu prijatelji, moze
        //da posalje zahtev sa proizvoljnim postid, pa je pitanje da li u tom slucaju treba pamtiti to u bazi
        $o = new Objava();
        if ($o->liked($userid, $postid)) {
            $o->unlike($userid, $postid);
            echo "liked";
        }
        else {
            $o->like($userid, $postid);
            echo "unliked";
        }
        return;
    }
    public function privatePost()
    {
        //proverava polja i evidentira novu objavu
        //vraca stranicu feed
        if (!$this->validate('post')) $this->data['error'] = $this->combineErrors();
        else $this->addPost($this->data['user']['id'], null);
        
        $this->showPage('feed', $this->data);
        return;
    }
    private function addPost($userid, $groupid) {
        $date = date("Y-m-d H:i:s", time());
        $o = new Objava();
        $id = $o->addPost($this->request->getVar('text'), null, $date, $userid, $groupid);
        $file = $this->request->getFile('img');
        if ($file->isValid()) {
            $img = 'objava-' . $id . '.' . $file->getClientExtension();
            $file->move(ROOT_DIR . UPLOAD_DIR, $img);
            $img = UPLOAD_DIR . "/" . $img;
            $o->setImg($id, $img);
        }
    }

    public function group($id) {
        //vraca stranicu grupe id
        $id = (int)$id;
        $g = new Grupa();
        $this->data["group"] = $group = $g->getGroup($id);
        $this->data["joined"] = $g->joined($id, $this->data['user']['id']);
        $this->session->set('pageid', $id);
        $this->showPage('group', $this->data);
        return;
    }
    public function joinGroup($id) {
        //uclanjuje/iscalnjuje ulogovanog korisnika iz grupe id
        //  1. Ako je korisnik uclanjen, izbacuje ga
        //  2. Ako korisnik nije uclanjen, uclanjuje ga
        //vraca stranicu group
        $id = (int)$id;
        $g = new Grupa();
        if ($g->joined($id, $this->data['user']['id'])) $g->unjoin($id, $this->data['user']['id']);
        else $g->join($id, $this->data['user']['id']);
        return redirect()->to(site_url("User/group/$id"));
    }
    public function groupPost($id) {
        //proverava polja i evidentira novu objavu u grupi id
        //vraca stranicu group
        if (!$this->validate('post')) $this->data['error'] = $this->combineErrors();
        else $this->addPost($this->data['user']['id'], $id);

        $this->data["group"] = TestData::$group;
        $this->data["joined"] = true;
        $this->showPage('group', $this->data);
        return;
    }

    public function profile($id) {
        //vraca profilnu stranicu
        //ako je id ulogovanog korisnika, onda vraca stranicu myprofile
        $id = (int) $id;
        $g = new Grupa();
        $k = new Korisnik();
        $this->data["groups"] = $g->getGroupsForProfile($id);
        $this->session->set('page', 'profile'); $this->session->set('pageid', $id);
        if ($this->data['user']['id'] == $id) $this->showPage('myprofile', $this->data);
        else {
            $this->data['profile'] = $k->rename($k->getUserById($id));
            $this->data['friendstatus'] = $k->getFriendStatus($this->data['user']['id'], $id);
            $this->showPage('profile', $this->data);
        }
        return;
    }
    public function updateProfile() {
        //azurira informacije profila ulogovanog korisnika
        //vraca stranicu profila sa azuriranim informacijama
        $g = new Grupa();
        $k = new Korisnik();
        $userid = $this->data['user']['id'];
        if (!$this->validate('myprofile'))  $this->data['error'] = $this->combineErrors();
        else {
            //evidentirati promene
            $file = $this->request->getFile('img');
            if ($file->isValid()) {
                $img = $this->data['user']['img'];
                if ($img != DEFAULT_PROF && file_exists(ROOT_DIR . $img)) unlink(ROOT_DIR . $img);
                $img = 'profil-' . $userid . '.' . $file->getClientExtension();
                $file->move(ROOT_DIR . UPLOAD_DIR, $img);
                $img = UPLOAD_DIR . "/" . $img;
            } else $img = null;
            $text = $this->request->getVar('text');
            $k->updateProfile($userid, $text, $img);
            $newuser = $k->rename($k->getUserById($userid));
            $this->data['user'] = $newuser;
            $this->session->set('user', $newuser);
        }
        $this->data["groups"] = $g->getGroupsForProfile($userid);
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
        $id = (int)$id;
        $userid = $this->data['user']['id'];
        if ($userid == $id) return redirect()->to(site_url("User/prifile/$id"));
        $k = new Korisnik();
        $status = $k->getFriendStatus($userid, $id);
        if ($status == "friends") $k->unfriend($userid, $id);
        else if ($status == "requested") $k->unrequest($userid, $id);
        else if ($status == "received") $k->accept($userid, $id);
        else $k->request($userid, $id);
        return redirect()->to(site_url("User/profile/$id"));
    }

    function comments($id) {
        //prikazuje stranicu sa komentarima za post id
        //proverava i da li ulogovani korisnik ima pravo pristupa do te objave (nema ako je privatna a autor nije prijatelj ulogovanog korisnika)
        
        
        $db= \Config\Database::connect();
        
        //dohvata objavu
        $rez1=$db->query("select * from objava where IdObj=?",[$id])->getResult();
        if(count($rez1)==0) return redirect()->to(site_url("User/feed")); //ako objava ne postoji vraca se ma pocetnu stranu
        
        //da li je grupna ili privatna objava
        
        $staJe=($rez1[0]->IdG==null?"privatna":"grupna");
        
        if($staJe=="privatna"){
            $user=$this->session->get("user");
            var_dump($user);
            echo $user['id'];
            $daLiJePrijatelj=$db->query("select * from jeprijatelj where IdK1=? and IdK2=? or IdK2=? and IdK1=?",[(int)$user['id'],(int)$rez1[0]->IdK,(int)$rez1[0]->IdK,(int)$user['id']])->getResult();
        
            if(count($daLiJePrijatelj)==0) return $redirect()->to(site_url ("User/feed"));
        }
        //dohvata broj lajkova za tu objavu
        $rez2=$db->query("select count(*) as Broj from lajkovao where IdObj=?",[$id])->getResult();
        
        //dohvata komentare za objavu
        $rez3=$db->query("select * from komentar where IdObj=?",[$id])->getResult();
        
        //dohvata korinsika koji je napisao tu objavu
        $rez4=$db->query("select * from korisnik where IdK=?",[$rez1[0]->IdK])->getResult();
        
        
        if($staJe=="privatna"){
            $posts=["id"=>$id,"text"=>$rez1[0]->Tekst,"likenum"=>$rez2[0]->Broj,"commentnum"=>count($rez3),"date"=>$rez1[0]->DatumVreme,"userid"=>$rez1[0]->IdK,"username"=>$rez4[0]->Ime." ".$rez4[0]->Prezime,"userimg"=>$rez4[0]->Slika];
        }else{
            //dohvati grupu u kojoj je napisana objava
            $rez5=$db->query("select * from grupa where IdG=?",[$rez1[0]->IdG])->getResult();
            $posts=["id"=>$id,"text"=>$rez1[0]->Tekst,"likenum"=>$rez2[0]->Broj,"commentnum"=>count($rez3),"date"=>$rez1[0]->DatumVreme,"userid"=>$rez1[0]->IdK,"username"=>$rez4[0]->Ime." ".$rez4[0]->Prezime,"userimg"=>$rez4[0]->Slika,"groupid"=>$rez1[0]->IdG,"groupname"=>$rez5[0]->Naziv];
        } 
    
        $comments=[];
        
        for($i=0;$i<count($rez3);$i++){
            //dohvata korisnika koji je napisao komentar na tu objavu
            $rez7=$db->query("select * from korisnik where IdK=?",[$rez3[$i]->IdK])->getResult();
            
            $comments[]=["username"=>$rez7[0]->Ime." ".$rez7[0]->Prezime,"userid"=>$rez3[$i]->IdK,"userimg"=>$rez7[$i]->Slika,"text"=>$rez3[$i]->Tekst];
        }
        
        var_dump($comments);
        //ostalo jos sta je liked
        
        
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
        
        $db= \Config\Database::connect();
        
        //dovati korisnike koji su poslali zahteve za prijateljsto idk1(ko salje)->idk2(ka kome se salje
        
        $res1=$db->query("select * from zahtevzaprijateljstvo where IdK2=?",[(int)$this->data['user']['id']])->getResult();
        
        $counter=count($res1);
        
        $requests=[];
        
        
        for($i=0;$i< $counter;$i++){
            //dovatanje podataka za jednog korisnika koji nam je oslao zahtev
            $res2=$db->query("select * from korisnik where IdK=?",[$res1[$i]->IdK1])->getResult();
            
            $requests[]=["id"=>$res1[$i]->IdK1,"name"=>$res2[0]->Ime." ".$res2[0]->Prezime,"img"=>$res2[0]->Slika,"text"=>$res2[0]->Opis];
            
        }
        
        
        $this->data["requests"] = $requests;
        $this->showPage('requests', $this->data);
        return;
    }
    
    function respond($id, $response) {
        //odgovara na zahtev za prijateljstvo od korisnika id u zavisnosti od response (yes ili no)
        
       $db= \Config\Database::connect();
       $daLiJePrazno=$db->query("select * from zahtevzaprijateljstvo where IdK1= ? and IdK2=?",[(int)$id,(int)$this->data['user']['id']]);
       
       if(count($daLiJePrazno)==0) return redirect()->to (site_url ("User/requests"));
       
        $daLiJePrazno=$db->query("select * from zahtevzaregistraciju where IdZah=?",[(int)$id])->getResult();
        
        if(count($daLiJePrazno)==0) return redirect()->to (site_url ("Admin/requests"));
        
        if($response=="yes"){
            $db->query("insert into jeprijatelj (IdK1,IdK2) values(?,?)",[(int)$id,(int)$this->data['user']['id']]);
        }
        $db->query("delete from zahtevzaprijateljstvo where IdK1= ? and IdK2=?",[(int)$id,(int)$this->data['user']['id']]);
        
        return redirect()->to(site_url("User/requests"));
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
        $this->session->destroy();
        return redirect()->to(site_url("Login/index"));
    }

    private function combineErrors() {
        $errors = $this->validator->getErrors();
        $msg = "";
        foreach($errors as $error) $msg .= $error . "</br>";
        return $msg;
    }
}