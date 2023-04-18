<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class MyRules {
    public function userExists($email) {
        //proveriti da li postoji korisnik u bazi
        return true;
    }
    public function checkPassword($password, $args, $data) {
        $email = $args;
        //proveriti da li lozinka odgovara imejl adresi
        return true;
    }
    public function checkEmailFormat($email) {
        return preg_match('/^[a-z]{2}\d{6}[a-z]@student.etf.bg.ac.rs$/', $email);
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
        'name'     => 'required',
        //'text'     => 'required',
        'img' => 'uploaded[img]|ext_in[img,png,jpg,jpeg]',
    ];
    public $admingroup_errors = [
        'name' => [
            'required' => 'Ime je obavezno.',
        ],
        'img' => [
            'uploaded' => 'Slika je obavezna.',
            'ext_in' => 'Dozvoljeni su samo png, jpg i jpeg fajlovi.'
        ],
    ];

    public $login = [
        'logemail' => 'required|userExists',
        'logpassword' => 'required|checkPassword[{email}]'
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
        'email' => 'required|checkEmailFormat',
        'name' => 'required',
        'lastname' => 'required',
        'password' => 'required',
        'password2' => 'required|matches[password]',
        //'img' => 'uploaded[img]|ext_in[img,png,jpg,jpeg]'
    ];
    public $register_errors = [
        'email' => [
            'required' => 'Unesite email.',
            'checkEmailFormat' => 'Format email adrese nije dobar.'
        ],
        'name' => [
            'required' => 'Unesite ime.',
        ],
        'lastname' => [
            'required' => 'Unesite prezime',
        ],
        'password' => [
            'required' => 'Unesite lozinku.',
        ],
        'password2' => [
            'required' => 'Unesite lozinku ponovo.',
            'matches' => 'Lozinka se ne poklapa'
        ],
        'img' => [
            'ext_in' => 'Dozvoljeni su samo png, jpg i jpeg fajlovi.'
        ]
    ];


}
