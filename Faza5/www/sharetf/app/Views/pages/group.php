<!-- $user = {"id", "name", "img"}, $group = {"img", "name", "text", "members", "id"}, $joined -->
            <div class="row">
                <div class="col-9" id = "group-main">
                  <div class="row border-bottom border-bottom-5 p-2 group-info">
                    <div class="col-4"><img src="<?= $group["img"] ?>" width="100%"></div>
                    <div class="col-8">
                      <h2><?= $group["name"] ?></h2>
                      <p><?= $group["text"] ?></p>
                      <p>Broj članova: <?= $group["members"] ?></p><button type="button" id = "join-button" class="btn <?= $joined ? "btn-secondary" : "btn-primary" ?>"><?= $joined ? "Učlani se" : "Iščlani se" ?></button>
                    </div>
                  </div>
                  <div class="row">
                    <div id="posts" class = "col-12">
                      
                    </div>
                  </div>
                </div>
                <div class="col-3 bg-logo-blue-light">

                </div>
            </div>
        </div>
        <script src = "/sharetf/public/scripts/elements.js"></script>
        <script src = "/sharetf/public/scripts/postLoader.js"></script>
        <script>
            user = {
              <?="
                userid: {$user['id']},
                userimg: '{$user['img']}',
                username: '{$user['name']}'
              "?>
            }
            $(document).ready(function() {
              $("#posts").append(makePostInput(user, "/sharetf/public/index.php/User/groupPost/<?=$group['id']?>"))
              loadMorePosts(makePost);
              $(window).scroll(function() {
                loadMorePosts(makePost);
              })
              $("#join-button").click(function() {
                window.location.href = "/sharetf/public/index.php/User/joinGroup/<?= $group["id"] ?>";
              })
            })
        </script>
        </body>
</html>