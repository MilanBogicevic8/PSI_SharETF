lastPostDate = "now";
currentlyFetching = false;

function bottom() {
    return $(window).scrollTop() + $(window).height() > $(document).height() - 10;
}
function loadMorePosts(postMaker) {
    if (currentlyFetching) return;
    if (!bottom()) return;
    currentlyFetching = true;
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '/sharetf/public/index.php/User/getPosts/' + lastPostDate, true);

    xhr.onload = function() {
        if (this.status == 200) {
            let data = JSON.parse(this.responseText);
            let result = [];
            /*{
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
            }*/
            for (let i = 0; i < data.length; i++) {
                $("#posts").append(postMaker(data[i]));
            }
            if (data.length > 0) lastPostDate = data[data.length-1].date;
        } else {
            console.error('Error fetching data');
        }
        currentlyFetching = false;
    };

    xhr.send();

}