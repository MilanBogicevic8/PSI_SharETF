lastPostDate = "2036-01-01 12:00:00";
currentlyFetching = false;

function bottom() {
    return $(window).scrollTop() + $(window).height() > $(document).height() - 10;
}
function loadMorePosts(postMaker) {
    if (!bottom()) return;
    loadPosts(postMaker);
}

function loadPosts(postMaker) {
    if (currentlyFetching) return;
    currentlyFetching = true;
    $.ajax({
        type: 'GET',
        url: baseURL+ '/User/getPosts?lasttime=' + lastPostDate
    }).done(function(response) {
        let data = JSON.parse(response);
        for (let i = 0; i < data.length; i++) {
            $("#posts").append(postMaker(data[i]));
        }
        if (data.length > 0) lastPostDate = data[data.length-1].date;
        currentlyFetching = false;
    });
}