<?php

namespace App\Controllers;

class TestData {
    public static $user = [
        "id" => 1,
        "img" => "/uploads/prof1.png",
        "name" => "Aleksa Vuckovic",
        "type" => "A",
        "text" => "Opis"
    ];
    public static $posts = [
        [
            "id" => 1,
            "text" => "Objava1",
            "likenum" => 10,
            "liked" => 0,
            "commentnum" => 3,
            "date" => "1.1.2020. 12:00:00",
            "userid" => 1,
            "username" => "Aleksa Vuckovic",
            "userimg" => "/uploads/prof1.png",
            "groupid" => 1,
            "groupname" => "Sistemski Softver"
        ],
        [
            "id" => 2,
            "text" => "Objava2",
            "likenum" => 10,
            "liked" => 1,
            "commentnum" => 3,
            "date" => "1.1.2020. 12:00:00",
            "userid" => 1,
            "username" => "Aleksa Vuckovic",
            "userimg" => "/uploads/prof1.png"
        ],
        [
            "id" => 3,
            "text" => "Objava3",
            "likenum" => 2,
            "liked" => 0,
            "commentnum" => 3,
            "date" => "1.1.2020. 12:00:00",
            "userid" => 1,
            "username" => "Aleksa Vuckovic",
            "userimg" => "/uploads/prof1.png",
            "groupid" => 1,
            "groupname" => "Sistemski Softver"
        ]
    ];
    //$group = {"img", "name", "text", "members", "id"}
    public static $group = [
        "id" => 1,
        "img" => "/uploads/group2.png",
        "name" => "Sistemski Softver",
        "text" => "Opis grupe",
        "members" => 100
    ];
    //{"username", "userid", "userimg", "text"}
    public static $comments = [
        [
            "username" => "Jana Janic",
            "userid" => 2,
            "userimg" => "/uploads/prof2.png",
            "text" => "Komentar1"
        ],
        [
            "username" => "Aleksa Vuckovic",
            "userid" => 1,
            "userimg" => "/uploads/prof1.png",
            "text" => "Komentar2"
        ]
    ];
    //$requests = [{"id", "name", "img", "text"}]
    public static $requests = [
        [
            "id" => 5,
            "name" => "Janko Jankovic",
            "img" => "/uploads/prof3.png",
            "text" => "Jankov opis"
        ],
        [
            "id" => 6,
            "name" => "Andjela Andjelic",
            "img" => "/uploads/prof5.png",
            "text" => "Andjelin opis"
        ]
    ];
    public static $regrequests = [
        [
            "id" => 5,
            "name" => "Janko Jankovic",
            "img" => "/uploads/prof3.png",
            "email" => "jj200035d@student.etf.bg.ac.rs"
        ],
        [
            "id" => 6,
            "name" => "Andjela Andjelic",
            "img" => "/uploads/prof5.png",
            "email" => "aa200035d@student.etf.bg.ac.rs"
        ]
    ];
}