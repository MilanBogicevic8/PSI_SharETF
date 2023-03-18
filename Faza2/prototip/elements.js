function makePostBase(data) {
    let img = data.img;
    let name = data.name;
    return $("<div></div>").addClass("border border-1 rounded-start p-2 my-4 shadow-sm post").append(
        $("<div></div>").addClass("border-bottom border-bottom-1 bg-light post-data ").append(
            $("<img>").attr("src", img).attr("height", "100px").addClass("rounded me-2")
        ).append(
            $("<a></a>").html(name).attr("href", "profile.html") //ovde treba staviti adresu konkretnog profila
        )
    ).append(
        $("<div></div>").addClass("post-content p-2")
    )
}
function makePost(post) {
    let img = post.img;
    let name = post.name;
    let text = post.text;
    let likenum = post.likenum;
    let commentnum = post.commentnum;

    let ret = makePostBase(post);
    ret.find(".post-content").append(
        $("<p></p>").html(text).addClass("mb-0")
    );
    let likenumSpan = $("<span></span>").text(likenum);
    let commentnumSpan = $("<span></span>").text(commentnum);
    ret.append(
        $("<div></div>").addClass("post-interactions px-2 bg-light").append(
            $("<i></i>").addClass("fa-regular fa-thumbs-up").click(function() {
                $(this).toggleClass("fa-solid fa-regular");
                if ($(this).hasClass("fa-solid")) {
                    likenumSpan.text(parseInt(likenumSpan.text())+1);
                    //Ovde treba serveru poslati zahtev da se lajk zapamti u bazi
                } else {
                    likenumSpan.text(parseInt(likenumSpan.text())-1);
                    //Ovde treba serveru poslati zahtev da se lajk izbrise iz baze
                }
            })
        ).append(likenumSpan).append(
            $("<span></span>").html("&nbsp;&nbsp;")
        ).append(
            $("<i></i>").addClass("fa-regular fa-comments").click(function(){
                //Ovde treba preci na stranicu tog konkretnog posta
                window.location.href="post.html";
            })
        ).append(commentnumSpan)
    )
    return ret;
}
function makePostWithGroup(post) {
    let groupName = post.groupName;
    let ret = makePost(post);
    if (groupName != null) ret.find(".post-data").append(
        $("<span></span>").text(" > ")
    ).append(
        $("<a></a>").text(groupName).attr("href", "group.html")
    )
    return ret;
}
function makePostInput(profile) {
    let img = profile.img;
    let name = profile.name;

    let ret = makePostBase(profile);
    ret.addClass("bg-light");
    ret.find(".post-content").append(
        $("<textarea></textarea>").addClass("form-control mb-1")
    ).append(
        $("<label></label>").attr("for", "post-input-image").addClass("form-label mb-0").html("Dodaj sliku: ")
    ).append(
        $("<input></input>").addClass("form-control").attr("type", "file").attr("id", "post-input-image")
    ).append(
        $("<button></button>").attr("type", "button").addClass("btn btn-primary mt-2").html("Objavi").click(function() {
            //Ovde treba serveru poslati zahtev za objavu
            alert("Objavljeno.")
        })
    );
    return ret;
}
function makeComment(comment) {
    let img = comment.img;
    let name = comment.name;
    let text = comment.text;

    let ret = makePostBase(comment);
    ret.find(".post-content").append(
        $("<p></p>").html(text).addClass("mb-0")
    );
    return ret;
}
function makeCommentInput(profile) {
    let img = profile.img;
    let name = profile.name;

    let ret = makePostBase(profile).addClass("bg-light");
    ret.find(".post-content").append(
        $("<textarea></textarea>").addClass("form-control mb-1")
    ).append(
        $("<button></button>").attr("type", "button").addClass("btn btn-primary mt-2").html("Objavi").click(function() {
            //Ovde treba poslati zahtev serveru
            alert("Objavljeno");
        })
    )
    return ret;
}

function makeGroupInfo(group) {
    let img = group.img;
    let name = group.name;
    let text = group.text;
    let memberNum = group.memberNum;
    let memberNumSpan = $("<span></span>").text(memberNum);
    return $("<div></div>").addClass("row border-bottom border-bottom-5 p-2 group-info").append(
        $("<div></div>").addClass("col-4").append(
            $("<img>").attr("src", img).attr("width", "100%")
        )
    ).append(
        $("<div></div>").addClass("col-8").append(
            $("<h2></h2>").html(name)
        ).append(
            $("<p></p>").html(text)
        ).append(
            $("<p></p>").append(
                $("<span></span>").html("Broj clanova: ")
            ).append(memberNumSpan)
        ).append(
            $("<button></button>").attr("type", "button").addClass("btn btn-primary").html("Učlani se").click(function() {
                if ($(this).text() == "Učlani se") {
                    //Ovde treba poslati zahtev serveru
                    $(this).text("Iščlani se");
                    $(this).toggleClass("btn-primary btn-secondary");
                    memberNumSpan.text(parseInt(memberNumSpan.text()) + 1);
                    alert("Učlanjeni ste")
                } else {
                    //Ovde treba poslati zahtev serveru
                    $(this).text("Učlani se");
                    $(this).toggleClass("btn-primary btn-secondary");
                    memberNumSpan.text(parseInt(memberNumSpan.text()) - 1);
                    alert("Iščlanjeni se ste")
                }
            })
        )
    )
}
function makeProfileInfo(profile) {
    let img = profile.img;
    let name = profile.name;
    let text = profile.text;
    return $("<div></div>").addClass("row border-bottom border-bottom-5 p-2 profile-info").append(
        $("<div></div>").addClass("col-2").append(
            $("<img>").attr("src", img).attr("width", "100%").addClass("rounded-1")
        )
    ).append(
        $("<div></div>").addClass("col-10").append(
            $("<h2></h2>").html(name)
        ).append(
            $("<p></p>").html(text)
        ).append(
            $("<button></button>").attr("type", "button").addClass("btn btn-primary").html("Dodaj prijatelja").click(function() {
                if ($(this).text() == "Dodaj prijatelja") {
                    //Ovde treba poslati zahtev serveru
                    $(this).text("Opozovi");
                    $(this).toggleClass("btn-primary btn-secondary");
                    alert("Zahtev je poslat")
                } else if ($(this).text() == "Opozovi") {
                    //Ovde treba poslati zahtev serveru
                    $(this).text("Dodaj prijatelja");
                    $(this).toggleClass("btn-primary btn-secondary");
                    alert("Zahtev je opozvan")
                }
            })
        )
    )
}

function makeEditableProfileInfo(profile) {
    let img = profile.img;
    let name = profile.name;
    let text = profile.text;
    let left = $("<div></div>").addClass("row border-bottom border-bottom-5 p-2 profile-info").append(
        $("<div></div>").addClass("col-2").append(
            $("<img>").attr("src", img).attr("width", "100%").addClass("rounded-1")
        )
    );
    let right1 = $("<div></div>").addClass("col-10");
    let right2 = $("<div></div>").addClass("col-10").hide();
    right1.append(
            $("<h2></h2>").html(name)
        ).append(
            $("<p></p>").html(text)
        ).append(
            $("<i></i>").addClass("fa-solid fa-pen-to-square").click(function() {
                right1.hide(); right2.show();
            })
        );
    right2.append(
            $("<h2></h2>").html(name)
        ).append(
            $("<textarea></textarea>").html(text).addClass("form-control mb-1")
        ).append(
            $("<label></label>").attr("for", "edit-photo").addClass("form-label").html("Ukoliko želite da promenite sliku, odaberite fajl:")
        ).append(
            $("<input></input>").attr("type", "file").addClass("form-control mb-2").attr("id", "edit-photo")
        ).append(
            $("<button></button>").attr("type", "button").addClass("btn btn-secondary").html("Ok").click(function() {
                right2.hide();
                right1.show();
            })
        );
    return left.append(right1).append(right2);
}

function makeGroupCard(group) {
    let img = group.img;
    let name = group.name;
    return $("<div></div>").addClass("card m-2 ms-0 group-card").append(
        $("<div></div>").addClass("row g-0").append(
            $("<div></div>").addClass("col-4").append(
                $("<img>").attr("src", img).addClass("img-fluid rounded-start")
            )
        ).append(
            $("<div></div>").addClass("col-8 d-flex align-items-center p-2").append(
                $("<h5></h5>").html(name)
            )
        )
    ).click(function() {
        //Ovde treba preci na stranicu te grupe
        window.location.href = "group.html"
    })
}

function makeHorizontalPreviewCard(data) {
    let img = data.img;
    let name = data.name;
    let text = shortVersion(data.text, 150);
    return $("<div></div>").addClass("card my-4 mx-2 preview-card").append(
        $("<div></div>").addClass("row g-0").append(
            $("<div></div>").addClass("col-2").append(
                $("<img>").attr("src", img).addClass("img-fluid rounded-start")
            )
        ).append(
            $("<div></div>").addClass("col-10 card-body p-2").append(
                $("<h5></h5>").html(name)
            ).append(
                $("<p></p>").html(text)
            )
        )
    )
}

function makeProfilePreview(profile) {
    return makeHorizontalPreviewCard(profile).click(function() {
        //Ovde treba preci na stranicu tog profila
        window.location.href = "profile.html";
    }).addClass("search-preview");
}
function makeGroupPreview(group) {
    return makeHorizontalPreviewCard(group).click(function() {
        //Ovde treba preci na stranicu te grupe
        window.location.href = "group.html";
    }).addClass("search-preview");
}

function makeRequestPreview(profile) {
    let ret = makeHorizontalPreviewCard(profile);
    ret.find(".card-body").append(
        $("<button></button>").attr("type", "button").addClass("btn btn-success").html("Prihvati").click(function() {
            //Ovde treba poslati zahtev serveru
            ret.remove();
            alert("Prijateljstvo je prihvaćeno.")
        })
    ).append(
        $("<span></span>").html("&nbsp;")
    )
    .append(
        $("<button></button>").attr("type", "button").addClass("btn btn-danger").html("Odbij").click(function() {
            //Ovde treba poslati zahtev serveru
            ret.remove();
            alert("Prijateljstvo je odbijeno.")
        })
    )
    return ret;
}

function makeAdminRequestPreview(request) {
    let data = {
        img: request.img,
        name: request.name,
        text: request.email
    };
    let ret = makeHorizontalPreviewCard(data);
    ret.find(".card-body").append(
        $("<button></button>").attr("type", "button").addClass("btn btn-success").html("Prihvati").click(function() {
            //Ovde treba poslati zahtev serveru
            ret.remove();
            alert("Zahtev za registraciju je prihvaćen.")
        })
    ).append(
        $("<span></span>").html("&nbsp;")
    )
    .append(
        $("<button></button>").attr("type", "button").addClass("btn btn-danger").html("Odbij").click(function() {
            //Ovde treba poslati zahtev serveru
            ret.remove();
            alert("Zahtev za registraciju je odbijen.")
        })
    )
    return ret;
}




function shortVersion(text, max) {
    if (text.length > max) {
        let len = max - 3;
        while (len > 0 && text[len-1] != " ") len--;
        if (len == 0) text = text + "..."
        else text = text.slice(0, len) + "..."
    }
    return text;
}