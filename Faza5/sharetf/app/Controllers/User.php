<?php
/*
    Autori:
    metode do sendRequest() - Aleksa Vučković 2020/0035
    metode od comments() - Milan Bogićević 2020/0284
*/

namespace App\Controllers;
use App\Models\Objava;
use App\Models\Grupa;
use App\Models\Korisnik;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserMethods;


/**
 * User - Kontroler za zahteve koje mogu da šalju samo registrovani korisnici i administratori.
 */
class User extends BaseController
{
    /**
     * @var array $data Podaci koji se prosleđuju u view
     */
    private $data = [];

    /**
     * Dodaje ulogovanog korisnika u $data
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->data['user'] = $this->session->get('user');
    }
    /**
     * Prikazuje feed stranicu
     */
    public function feed()
    {
        if ($this->session->has('error')) {
            $this->data['error'] = $this->session->get('error');
            $this->session->remove('error');
        }
        //vraca feed za ulogovanog korisnika
        $this->showPage('feed', $this->data);
    }
    /**
     * Vraća narednih 20 objava za ulogovanog korisnika, počev od prosleđenog datuma unazad, u json formatu.
     * Postovi koji se vraćaju zavise od stranice na kojoj se nalazi korisnik:
     *  1. Feed -> Svi relevantni (Grupe čiji je clan, njegovi prijatelji)
     *  2. Group -> Samo iz te grupe
     *  3. Profil prijatelja -> Svi postovi tog korisnika
     *  4. Profil ne-prijatelja -> Samo grupni postovi tog korisnika
     * Zbog ovoga treba pamtiti u okviru sesije na kojoj je stranici korisnik, i za profilnu stranicu koji je id korisnika.
     * U session['page'] cuva se stranica (feed, group, profile, myprofile), a u session['pageid'] id profila za stranicu profile, odnosno id grupe za stranicu grupe.
     * Na taj način ce se na svim stranicama na front-endu uniformno implementira dinamičko učitavanje postova, koristeći isti zahtev i istu skriptu (postLoader.js)
     * Format u kom se vraćaju postovi je sledeći:
     *      {
     *          id: 1,
     *          text: "Objava",
     *          likenum: 1,
     *          liked: 0,
     *          commentnum: 1,
     *          img: "/uploads/slika.png",
     *          date: "1.1.2002. 12:00:00",
     *          userid: 1,
     *          username: "Ime Prezime",
     *          userimg: "/uploads/slika.png",
     *          groupid: 1,
     *          groupname: "Grupa" 
     *      }
     *  groupid i groupname postoje samo za grupne postove, a img samo za postove sa slikom. Vraća se niz od maksimalno 20 ovakvih objekata.
     *  Polje liked = 0 znači da ulogovani korisnik nije lajkovao post, a 1 da jeste.
     */
    public function getPosts()
    {
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
    /**
     * Obrađuje zahtev za slanje, odnosno povlačenje lajka, u zavisnosti od trenutnog stanja.
     */
    public function like($postid)
    {
        $userid = $this->data['user']['id'];
        $postid = (int)$postid;

        //Možda bi trebalo dodati i proveru, ako je objava privatna, da li su korisnici prijatelji?
        //Iako korisnik nikako ne može da vidi privatne objave korisnika koji mu nisu prijatelji, može
        //da pošalje zahtev sa proizvoljnim postid, pa je pitanje da li u tom slucaju treba pamtiti to u bazi.
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
    /**
     * Dodaju privatnu objavu, pri čemu se parametri prosleđuju kao POST zahtev.
     * Vraća feed stranicu.
     */
    public function privatePost()
    {
        if (!$this->validate('post')) $this->session->set('error', $this->combineErrors());
        else $this->addPost($this->data['user']['id'], null);
        
        return redirect()->to(site_url('User/feed'));
    }
    /**
     * Privatna metoda za dodavanje postova koja se koristi u obradi zahteva kod privatePost() i groupPost().
     * 
     * @param int $userid ID korisnika koji objavljuje
     * @param int $groupid ID grupe u kojoj se objavljuje, null ako je privatna
     */
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

    /**
     * Vraća stranicu grupe.
     * 
     * @param int $id ID grupe čija se stranica prikazuje
     */
    public function group($id) {
        $id = (int)$id;
        $g = new Grupa();
        if ($this->session->has('error')) {
            $this->data['error'] = $this->session->get('error');
            $this->session->remove('error');
        }
        $this->data["group"] = $g->getGroup($id);
        $this->data["joined"] = $g->joined($id, $this->data['user']['id']);
        $this->session->set('pageid', $id);
        $this->showPage('group', $this->data);
        return;
    }
    /**
     * Učlanjuje/Iščlanjuje ulogovanog korisnika iz grupe id, u zavisnosti od toga da li je korisnik već učlanjen.
     * 
     * @param int $id ID grupe na koju se odnosi zahtev
     */
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

    /**
     * Obrađuje dodavanje nove objave u grupu id. Vraća stranicu za prikaz grupe.
     * 
     * @param int $id ID grupe u koju se dodaje objava
     */
    public function groupPost($id) {
        if (!$this->validate('post')) $this->session->set('error', $this->combineErrors());
        else $this->addPost($this->data['user']['id'], $id);

        return redirect()->to("User/group/$id");
    }

    /**
     * Vraća stranicu za prikaz profila.
     * Ako je prosleđen ID ulogovanog korisnika vraća myprofile stranicu, sa odgovarajućim opcijama.
     * 
     * @param int $id ID korisnika čiji profil se traži
     */
    public function profile($id) {
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

    /**
     * Ažurira informacije profila ulogovanog korisnika.
     * Vraća stranicu profila sa azuriranim informacijama.
     */
    public function updateProfile() {
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
                $img = 'profil-' . $userid . '-' . rand(1, 1000) . '.' . $file->getClientExtension();
                $file->move(ROOT_DIR . UPLOAD_DIR, $img);
                $img = UPLOAD_DIR . "/" . $img;
            } else $img = null;
            $text = $this->request->getVar('text');
            $k->updateProfile($userid, $text, $img);
            $newuser = $k->rename($k->getUserById($userid));
            $this->session->set('user', $newuser);
        }
        return redirect()->to(site_url("User/profile/$userid"));
    }
    /**
     * Šalje zahtev za prijateljstvo od ulogovanog korisnika ka korisniku id.
     * Postoji više mogućnosti:
     *  1. Ako je zahtev već poslat, opoziva se
     *  2. Ako je korisnik id već poslao zahtev ulogovanom korisniku, prijateljstvo se evidentira
     *  3. Ako je korisnik već prijatelj, briše se prijateljstvo
     *  4. U suprotnom zahtev se evidentira
     * Vraća stranicu istog profila sa ažuriranim podacima.
     */
    public function sendRequest($id) {
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

    /**
     * 
     * prikazuje stranicu sa komentarima za post id
     * proverava i da li ulogovani korisnik ima pravo pristupa do te objave (nema ako je privatna a autor nije prijatelj ulogovanog korisnika)
     * @param type $id ID objave koja se komentarise
     * 
     */
    function comments($id) {
        
        $db= \Config\Database::connect();
        
        //dohvata objavu
        $rez1=$db->query("select * from objava where IdObj=?",[$id])->getResult();
        if(count($rez1)==0) return redirect()->to(site_url("User/feed")); //ako objava ne postoji vraca se na pocetnu stranu
        
        //da li je grupna ili privatna objava
        
        $staJe=($rez1[0]->IdG==null?"privatna":"grupna");
        
        if($staJe=="privatna"){
            $user=$this->session->get("user");
            //var_dump($user);
            //echo $user['id'];
            
            $daLiJePrijatelj=$db->query("select * from jeprijatelj where IdK1=? and IdK2=? or IdK1=? and IdK2=?",[(int)$user['id'],(int)$rez1[0]->IdK,(int)$rez1[0]->IdK,(int)$user['id']])->getResult();
        
            if(count($daLiJePrijatelj)==0 && $this->session->get("user")['id']!=$rez1[0]->IdK ) return redirect()->to(site_url ("User/feed"));
        }
        
        
        //dohvata broj lajkova za tu objavu
        $rez2=$db->query("select count(*) as Broj from lajkovao where IdObj=?",[$id])->getResult();
        
        //dohvata komentare za objavu
        $rez3=$db->query("select * from komentar where IdObj=?",[$id])->getResult();
        
        //dohvata korinsika koji je napisao tu objavu
        $rez4=$db->query("select * from korisnik where IdK=?",[$rez1[0]->IdK])->getResult();
        
        //proverava da li je osoba koja je poslala zahtev lajkovala tu objavu
        $rez8=$db->query("select * from korisnik k where k.IdK=? and k.IdK in (select l.IdK from lajkovao l where l.idobj=?)",[$this->session->get('user')['id'],(int)$id])->getResult();
        $daLiJeLajkovao=count($rez8);
        
        if($staJe=="privatna"){
            $posts=["id"=>$id,"text"=>$rez1[0]->Tekst,"likenum"=>$rez2[0]->Broj,"liked"=>$daLiJeLajkovao,"commentnum"=>count($rez3),"date"=>$rez1[0]->DatumVreme,"img"=>$rez1[0]->Slika ,"userid"=>$rez1[0]->IdK,"username"=>$rez4[0]->Ime." ".$rez4[0]->Prezime,"userimg"=>$rez4[0]->Slika];
        }else{
            //dohvati grupu u kojoj je napisana objava
            $rez5=$db->query("select * from grupa where IdG=?",[$rez1[0]->IdG])->getResult();
            $posts=["id"=>$id,"text"=>$rez1[0]->Tekst,"likenum"=>$rez2[0]->Broj,"liked"=>$daLiJeLajkovao,"commentnum"=>count($rez3),"date"=>$rez1[0]->DatumVreme,"img"=>$rez1[0]->Slika ,"userid"=>$rez1[0]->IdK,"username"=>$rez4[0]->Ime." ".$rez4[0]->Prezime,"userimg"=>$rez4[0]->Slika,"groupid"=>$rez1[0]->IdG,"groupname"=>$rez5[0]->Naziv];
        } 
    
        $comments=[];
        
        //var_dump($rez3);
        
        $count2=count($rez3);
        for($i=0;$i<$count2;$i++){
            //dohvata korisnika koji je napisao komentar na tu objavu
            
            $rez7=$db->query("select * from korisnik where IdK=?",[$rez3[$i]->IdK])->getResult();
            
            $comments[]=["username"=>$rez7[0]->Ime." ".$rez7[0]->Prezime,"userid"=>$rez3[$i]->IdK,"userimg"=>$rez7[0]->Slika,"text"=>$rez3[$i]->Tekst];
        }
        
        
        $this->data["post"] = $posts;
        $this->data['comments'] = $comments;
        $this->showPage('post', $this->data);
        return;
    }
    
    /**
     * 
     * dodaje komentar na post id, za ulogovanog korisnika
     * vraca stranicu sa azuriranim komentarima
     * @param type $id ID objave koja se komentarise
     */
    function addComment($id) {
        //
        //
        
        $db= \Config\Database::connect();
        //var_dump($_REQUEST);
        $comment=$this->request->getVar("text");
        
        
        
        
        if (!$this->validate('comment')) $this->data['error'] = $this->combineErrors();
        
        if(empty($this->data['error'])){
            
            $db->query("insert into komentar(IdK,IdObj,Tekst) values (?,?,?)",[$this->session->get("user")['id'],$id,$comment]);
        }
        
        
        //dohvata objavu
        $rez1=$db->query("select * from objava where IdObj=?",[$id])->getResult();
        if(count($rez1)==0) return redirect()->to(site_url("User/feed")); //ako objava ne postoji vraca se na pocetnu stranu
        
        //da li je grupna ili privatna objava
        
        $staJe=($rez1[0]->IdG==null?"privatna":"grupna");
        
        
        
        //dohvata broj lajkova za tu objavu
        $rez2=$db->query("select count(*) as Broj from lajkovao where IdObj=?",[$id])->getResult();
        
        //dohvata komentare za objavu
        $rez3=$db->query("select * from komentar where IdObj=?",[$id])->getResult();
        
        //dohvata korinsika koji je napisao tu objavu
        $rez4=$db->query("select * from korisnik where IdK=?",[$rez1[0]->IdK])->getResult();
        
        //proverava da li je osoba koja je poslala zahtev lajkovala tu objavu
        $rez8=$db->query("select * from korisnik k where k.IdK=? and k.IdK in (select l.IdK from lajkovao l where l.idobj=?)",[$this->session->get('user')['id'],(int)$id])->getResult();
        $daLiJeLajkovao=count($rez8);
        
        if($staJe=="privatna"){
            $posts=["id"=>$id,"text"=>$rez1[0]->Tekst,"likenum"=>$rez2[0]->Broj,"liked"=>$daLiJeLajkovao,"commentnum"=>count($rez3),"date"=>$rez1[0]->DatumVreme,"userid"=>$rez1[0]->IdK,"username"=>$rez4[0]->Ime." ".$rez4[0]->Prezime,"userimg"=>$rez4[0]->Slika];
        }else{
            //dohvati grupu u kojoj je napisana objava
            $rez5=$db->query("select * from grupa where IdG=?",[$rez1[0]->IdG])->getResult();
            $posts=["id"=>$id,"text"=>$rez1[0]->Tekst,"likenum"=>$rez2[0]->Broj,"liked"=>$daLiJeLajkovao,"commentnum"=>count($rez3),"date"=>$rez1[0]->DatumVreme,"userid"=>$rez1[0]->IdK,"username"=>$rez4[0]->Ime." ".$rez4[0]->Prezime,"userimg"=>$rez4[0]->Slika,"groupid"=>$rez1[0]->IdG,"groupname"=>$rez5[0]->Naziv];
        } 
    
        $comments=[];
        
        //var_dump($rez3);
        
        $count2=count($rez3);
        for($i=0;$i<$count2;$i++){
            //dohvata korisnika koji je napisao komentar na tu objavu
            
            $rez7=$db->query("select * from korisnik where IdK=?",[$rez3[$i]->IdK])->getResult();
            
            $comments[]=["username"=>$rez7[0]->Ime." ".$rez7[0]->Prezime,"userid"=>$rez3[$i]->IdK,"userimg"=>$rez7[0]->Slika,"text"=>$rez3[$i]->Tekst];
        }
        
        
        //ostalo jos sta je liked
        
        
        $this->data["post"] = $posts;
        $this->data['comments'] = $comments;
        
        $this->showPage('post', $this->data);
    }

    /**
     * 
     * prikazuje stranicu sa zahtevima za prijateljstvo za ulogovanog korisnika,
     * 
     */
    public function requests()
    {
        //var_dump($this->session->get('user'));
        $usr=new UserMethods();
        $db = \Config\Database::connect();
        $requests = $usr->getFriendRequests($db,$this->data);
        $this->data["requests"] = $requests;
        $this->showPage('requests', $this->data);
        return;
    }

    

    
    /**
     * Odgovara na zahtev za prijateljstvo od korisnika ID u zavisnosti od odgovora (yes ili no).
     *
     * @param int $id ID korisnika
     * @param string $response Odgovor ('yes' ili 'no')
     */
    public function respond($id, $response)
    {
        $usr=new UserMethods();
        $db = \Config\Database::connect();
        $requestExists = $usr->checkFriendRequest($db, $id,$this->data);

        if (!$requestExists) {
            return redirect()->to(site_url("User/requests"));
        }

        if ($response == "yes") {
            $usr->addFriend($db, $id,$this->data);
        }

        $usr->deleteFriendRequest($db, $id,$this->data);

        return redirect()->to(site_url("User/requests"));
    }

    public function search() {
        $this->showPage('search', $this->data);
    }
    
    
    /**
     * 
     * @param type $term specijalna vrednost za term je "all", i oznacava prikaz svih profila/grupa
     * @param type $type type je "profile" ili "group"
     * @return type vraca json listu rezultata pretrage
     * 
     * 
     */
    
    
    public function getSearchResults($term, $type)
    {
        $requests = [];
        $db = \Config\Database::connect();
        $usr=new UserMethods();
        if ($type == "profile") {
            $rez1 = $usr->getProfilesFromDatabase($db, $term);
            foreach ($rez1 as $profile) {
                $requests[] = [
                    "id" => $profile->IdK,
                    "name" => $profile->Ime . " " . $profile->Prezime,
                    "img" => $profile->Slika,
                    "text" => $profile->Opis
                ];
            }
        } else if ($type == "group") {
            $rez1 = $usr->getGroupsFromDatabase($db, $term);
            foreach ($rez1 as $group) {
                $requests[] = [
                    "id" => $group->IdG,
                    "name" => $group->Naziv,
                    "img" => $group->Slika,
                    "text" => $group->Opis
                ];
            }
        }

        echo json_encode($requests);
        return;
    }

    

    

    /**
     * 
     * brise session
     * vraca na login stranicu
     * 
     * 
     */
    public function logout() {
        
        $this->session->destroy();
        return redirect()->to(site_url("Login/index"));
    }
    
    /**
     * metoda za ispis gresaka
     * @return string
     * 
     */

    private function combineErrors() {
        $errors = $this->validator->getErrors();
        $msg = "";
        foreach($errors as $error) $msg .= $error . "</br>";
        return $msg;
    }
}