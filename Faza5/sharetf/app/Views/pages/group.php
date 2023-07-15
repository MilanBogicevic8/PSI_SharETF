<!-- $user = {"id", "name", "img"}, $group = {"img", "name", "text", "members", "id"}, $joined, ?$error -->
            <div class="row">
                <div class="col-lg-9 col-md-12" id = "group-main">
                  <div class="row border-bottom border-bottom-5 p-2 group-info">
                    <div class="col-md-4 col-sm-12"><img src="<?= $group["img"] ?>" width="100%"></div>
                    <div class="col-md-8 col-sm-12">
                      <h2><?= $group["name"] ?></h2>
                      <p><?= $group["text"] ?></p>
                      <p>Broj članova: <?= $group["members"] ?></p><button type="button" id = "join-button" class="btn <?= $joined ? "btn-secondary" : "btn-primary" ?>"><?= $joined ? "Iščlani se" : "Učlani se" ?></button>
                    </div>
                  </div>
                  <div class="row">
                    <div id="posts" class = "col-12">
                      
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-0 bg-logo-blue-light">

                </div>
            </div>
        </div>
        <script src = "/sharetf/public/scripts/elements.js"></script>
        <script src = "/sharetf/public/scripts/postLoader.js"></script>
        <script>
            var baseURL = '<?= site_url() ?>';
            user = {
              <?="
                userid: {$user['id']},
                userimg: '{$user['img']}',
                username: '{$user['name']}'
              "?>
            }
            $(document).ready(function() {
              $("#posts").append(makePostInput(user, "/sharetf/public/index.php/User/groupPost/<?=$group['id']?>", <?= empty($error) ? "'', null" : "`" . set_value('text') . "`, '$error'" ?>));
              loadPosts(makePost);
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