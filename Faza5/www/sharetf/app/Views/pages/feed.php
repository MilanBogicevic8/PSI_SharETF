<!-- $user = {"id", "img", "name"}, ?$error -->
            <div class="row">
                <div class="col-9">
                  <div class="row">
                    <div class="col-12 pt-3">
                        <h2>Feed</h2>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12" id = "posts">
                      
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
              <?= "
                userid: {$user['id']},
                userimg: '{$user['img']}',
                username: '{$user['name']}'
              "
              ?>
            };
            $(document).ready(function() {
              $("#posts").append(makePostInput(user, "/sharetf/public/index.php/User/privatePost", <?= empty($error) ? "'', null" : "`" . set_value('text') . "`, '$error'" ?>));
              loadPosts(makePostWithGroup);
              $(window).scroll(function() {
                loadMorePosts(makePostWithGroup);
              })
            })
        </script>
        </body>
</html>