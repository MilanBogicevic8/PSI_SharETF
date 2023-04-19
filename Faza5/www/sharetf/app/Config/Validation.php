<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Models\Korisnik;
use App\Models\ZahtevZaRegistraciju;

class MyRules {
    public function userExists($email) {
        //proveriti da li postoji korisnik u bazi
        $k = new Korisnik();
        $user = $k->getUser($email);
        return $user != null;
    }
    public function checkPassword($password, $args, $data) {
        $email = $args;
        $k = new Korisnik();
        $user = $k->getUser($email);
        return $user == null || $password == $user['Lozinka'];
    }
    public function checkEmailFormat($email) {
        return preg_match('/^[a-z]{2}\d{6}[a-z]@student.etf.bg.ac.rs$/', $email);
    }
    public function checkEmailUnique($email) {
        $k = new Korisnik();
        $z = new ZahtevZaRegistraciju();
        return $k->getUser($email) == null && !$z->exists($email);
    }

}

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        MyRules::class
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $admingroup = [
        'name'     => 'required|max_length[200]',
        'text'     => 'max_length[1000]',
        'img' => 'uploaded[img]|ext_in[img,png,jpg,jpeg]|mime_in[img,image/png,image/jpeg]',
    ];
    public $admingroup_errors = [
        'name' => [
            'required' => 'Ime je obavezno.',
            'max_length' => 'Maksimalna dužina imena je 200 karaktera.'
        ],
        'text' => [
            'max_length' => 'Maksimalna dužina opisa je 1000 karaktera.'
        ],
        'img' => [
            'uploaded' => 'Slika je obavezna.',
            'ext_in' => 'Dozvoljeni su samo png, jpg i jpeg fajlovi.',
            'mime_in' => 'Dozvoljeni su samo png, jpg i jpeg fajlovi.'
        ],
    ];

    public $login = [
        'logemail' => 'required|userExists',
        'logpassword' => 'required|checkPassword[{logemail}]'
    ];
    public $login_errors = [
        'logemail' => [
            'required' => 'Unesite email.',
            'userExists' => 'Korisnik ne postoji.'
        ],
        'logpassword' => [
            'required' => 'Unesite lozinku.',
            'checkPassword' => 'Pogrešna lozinka.'
        ]
    ];

    public $register = [
        'email' => 'required|checkEmailFormat|checkEmailUnique',
        'name' => 'required|max_length[200]',
        'lastname' => 'required|max_length[200]',
        'password' => 'required|max_length[200]',
        'password2' => 'required|matches[password]',
        'img' => 'ext_in[img,png,jpg,jpeg]|mime_in[img,image/png,image/jpeg]'
    ];
    public $register_errors = [
        'email' => [
            'required' => 'Unesite email.',
            'checkEmailFormat' => 'Format email adrese nije dobar.',
            'checkEmailUnique' => 'Korisnik sa unetom email adresom već postoji.'
        ],
        'name' => [
            'required' => 'Unesite ime.',
            'max_length' => 'Maksimalna dužina imena je 200 karaktera.'
        ],
        'lastname' => [
            'required' => 'Unesite prezime',
            'max_length' => 'Maksimalna dužina prezimena je 200 karaktera.'
        ],
        'password' => [
            'required' => 'Unesite lozinku.',
            'max_length' => 'Maksimalna dužina lozinke je 200 karaktera.'
        ],
        'password2' => [
            'required' => 'Unesite lozinku ponovo.',
            'matches' => 'Lozinka se ne poklapa'
        ],
        'img' => [
            'ext_in' => 'Dozvoljeni su samo png, jpg i jpeg fajlovi.',
            'mime_in' => 'Dozvoljeni su samo png, jpg i jpeg fajlovi.'
        ]
    ];
    
    public $post = [
        'text' => 'max_length[1000]',
        'img' => 'ext_in[img,png,jpg,jpeg]|mime_in[img,image/png,image/jpeg]'
    ];
    public $post_errors = [
        'text' => [
            'max_length' => 'Maksimalna dužina objave je 1000 karaktera.'
        ],
        'img' => [
            'ext_in' => 'Dozvoljeni su samo png, jpg i jpeg fajlovi.',
            'mime_in' => 'Dozvoljeni su samo png, jpg i jpeg fajlovi.'
        ]
    ];

    public $myprofile = [
        'text' => 'max_length[1000]'
    ];
    public $myprofile_errors = [
        'text' => [
            'max_length' => 'Maksimalna dužina opisa je 1000 karaktera.'
        ]
    ];

    public $comment = [
        'text' => 'max_length[1000]'
    ];
    public $comment_errors = [
        'text' => [
            'max_length' => 'Maksimalna dužina komentara je 1000 karaktera.'
        ]
    ];

}
