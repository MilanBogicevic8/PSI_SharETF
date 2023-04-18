// Autor: Aleksa Vučković
function makePostBase(data) {
    let userimg = data.userimg;
    let username = data.username;
    let userid = data.userid;
    return $("<div></div>").addClass("border border-1 rounded-start p-2 my-4 shadow-sm post").append(
        $("<div></div>").addClass("border-bottom border-bottom-1 bg-light post-data ").append(
            $("<img>").attr("src", userimg).attr("height", "100px").addClass("rounded me-2")
        ).append(
            $("<a></a>").html(username).attr("href", "/sharetf/public/index.php/User/profile/" + userid) //ovde treba staviti adresu konkretnog profila
        )
    ).append(
        $("<div></div>").addClass("post-content p-2")
    )
}
function makePost(post) {
    let id = post.id;
    let text = post.text;
    let likenum = post.likenum;
    let liked = post.liked;
    let commentnum = post.commentnum;
    let date = post.date;

    let ret = makePostBase(post);
    ret.find(".post-content").append(
        $("<p></p>").html(text).addClass("mb-0")
    );
    let likenumSpan = $("<span></span>").text(likenum);
    let commentnumSpan = $("<span></span>").text(commentnum);
    ret.append(
        $("<div></div>").addClass("post-interactions px-2 bg-light").append(
            $("<i></i>").addClass((liked == 1 ? "fa-solid" : "fa-regular") + " fa-thumbs-up").click(function() {
                $(this).toggleClass("fa-solid fa-regular");
                if ($(this).hasClass("fa-solid")) likenumSpan.text(parseInt(likenumSpan.text())+1);
                else likenumSpan.text(parseInt(likenumSpan.text())-1);
                
                let xhr = new XMLHttpRequest();
                xhr.open('GET', '/sharetf/public/index.php/User/like/' + id, true);
                xhr.send();
            })
        ).append(likenumSpan).append(
            $("<span></span>").html("&nbsp;&nbsp;")
        ).append(
            $("<i></i>").addClass("fa-regular fa-comments").click(function(){
                //Ovde treba preci na stranicu tog konkretnog posta
                window.location.href="/sharetf/public/index.php/User/comments/" + id;
            })
        ).append(commentnumSpan).append(
            $("<span></span>").addClass("float-end").text(date)
        )
    )
    return ret;
}
function makePostWithGroup(post) {
    let groupname = post.groupname;
    let groupid = post.groupid;
    let ret = makePost(post);
    if (groupname != null) ret.find(".post-data").append(
        $("<span></span>").text(" > ")
    ).append(
        $("<a></a>").text(groupname).attr("href", "/sharetf/public/index.php/User/group/" + groupid)
    )
    return ret;
}

function makePostInput(profile, action) {
    let ret = makePostBase(profile);
    ret.addClass("bg-light");
    ret.find(".post-content").append(
        $("<form></form>").attr("method", "post").attr("action", action).attr("enctype", "multipart/form-data").append(
            $("<textarea></textarea>").addClass("form-control mb-1").attr("name", "text")
        ).append(
            $("<label></label>").attr("for", "post-input-image").addClass("form-label mb-0").html("Dodaj sliku: ")
        ).append(
            $("<input></input>").addClass("form-control").attr("type", "file").attr("id", "post-input-image").attr("name", "img")
        ).append(
            $("<input></input>").attr("type", "submit").addClass("btn btn-primary mt-2").html("Objavi")
        )
    )
    return ret;
}
function makeComment(comment) {
    let text = comment.text;

    let ret = makePostBase(comment);
    ret.find(".post-content").append(
        $("<p></p>").html(text).addClass("mb-0")
    );
    return ret;
}

function makeCommentInput(profile, postid) {
    let ret = makePostBase(profile).addClass("bg-light");
    ret.find(".post-content").append(
        $("<form></form>").attr("method", "post").attr("action", "/sharetf/public/index.php/User/addComment/" + postid).append(
            $("<textarea></textarea>").addClass("form-control mb-1")
        ).append(
            $("<input></input>").attr("type", "submit").addClass("btn btn-primary mt-2").html("Objavi")
        )
    )
    return ret;
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
        window.location.href = "/sharetf/public/index.php/User/group/" + id;
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
    let id = profile.id;
    return makeHorizontalPreviewCard(profile).click(function() {
        //Ovde treba preci na stranicu tog profila
        window.location.href = "/sharetf/public/index.php/User/profile/" + id;
    }).addClass("search-preview");
}
function makeGroupPreview(group) {
    let id = group.id;
    return makeHorizontalPreviewCard(group).click(function() {
        //Ovde treba preci na stranicu te grupe
        window.location.href = "/sharetf/public/index.php/User/group/" + id;
    }).addClass("search-preview");
}

function makeRequestPreview(profile) {
    let ret = makeHorizontalPreviewCard(profile);
    ret.find(".card-body").append(
        $("<button></button>").attr("type", "button").addClass("btn btn-success").html("Prihvati").click(function() {
            //Ovde treba poslati zahtev serveru
            let xhr = new XMLHttpRequest();
            xhr.open('GET', '/sharetf/public/index.php/User/respond/' + profile.id + '/yes');
            xhr.send();
            ret.remove();
        })
    ).append(
        $("<span></span>").html("&nbsp;")
    )
    .append(
        $("<button></button>").attr("type", "button").addClass("btn btn-danger").html("Odbij").click(function() {
            //Ovde treba poslati zahtev serveru
            let xhr = new XMLHttpRequest();
            xhr.open('GET', '/sharetf/public/index.php/User/respond/' + profile.id + '/no');
            xhr.send();
            ret.remove();
        })
    )
    return ret;
}

function makeAdminRequestPreview(request) {
    let ret = makeHorizontalPreviewCard(request);
    ret.find(".card-body").append(
        $("<button></button>").attr("type", "button").addClass("btn btn-success").html("Prihvati").click(function() {
            //Ovde treba poslati zahtev serveru
            let xhr = new XMLHttpRequest();
            xhr.open('GET', '/sharetf/public/index.php/Admin/respond/' + request.id + '/yes');
            xhr.send();
            ret.remove();
        })
    ).append(
        $("<span></span>").html("&nbsp;")
    )
    .append(
        $("<button></button>").attr("type", "button").addClass("btn btn-danger").html("Odbij").click(function() {
            //Ovde treba poslati zahtev serveru
            let xhr = new XMLHttpRequest();
            xhr.open('GET', '/sharetf/public/index.php/Admin/respond/' + request.id + '/no');
            xhr.send();
            ret.remove();
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