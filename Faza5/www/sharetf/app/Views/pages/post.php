<!-- $post = [{"id", "text", "likenum", "liked", "commentnum", "img", "date", "userid", "username", "groupid", "groupname"}],
$user = {"userid", "img", "username"}, $comments = [{"username", "userid", "userimg", "text"}], ?$error -->
            <div class="row">
                <div class="col-12 pt-3">
                    <h2>Komentari</h2>
                </div>
            </div>
            <div class="row border-bottom border-bottom-4">
                <div class="col-10" id = "post-main">
                  
                </div>
            </div>
            <div class="row bg-light">
                <div class="col-8" id = "post-comments">

                </div>
            </div>
        </div>
        <script src = "/sharetf/public/scripts/elements.js"></script>
        <script>
            post = {
              <?= "
                id: {$post['id']},
                text: '{$post['text']}',
                likenum: {$post['likenum']},
                liked: {$post['liked']},
                commentnum: {$post['likenum']},
                img: " . (isset($post['img']) ? "'" . $post['img'] . "'" : "null") . ",
                date: '{$post['date']}',
                userid: {$post['userid']},
                username: '{$post['username']}',
                userimg: '{$post['userimg']}',
                groupid: " . ($post['groupid'] ?? "null") . ",
                groupname: " . (isset($post['groupname']) ? "'" . $post['groupname'] . "'" : "null")
              ?>
            };
            user = {
              <?="
                userid: {$user['id']},
                userimg: '{$user['img']}',
                username: '{$user['name']}'
              "?>
            };
            comments = [
              <?php
                for ($i = 0; $i < count($comments); $i++) {
                  echo ("{
                    username: '{$comments[$i]['username']}',
                    userid: {$comments[$i]['userid']},
                    userimg: '{$comments[$i]['userimg']}',
                    text: '{$comments[$i]['text']}',
                  }");
                  if ($i != count($comments) - 1) echo ",";
                }
              ?>
            ]
            $(document).ready(function() {
              $("#post-main").append(makePostWithGroup(post));
              $("#post-comments").append(makeCommentInput(user, post.id, <?= empty($error) ? "'', null" : "`" . set_value('text') . "`, '$error'" ?>));
              for (let i = 0; i < comments.length; i++) {
                $("#post-comments").append(makeComment(comments[i]));
              }
            })
        </script>
        </body>
</html>