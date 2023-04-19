<!-- $user = {"name", "text", "img"}, $groups = [{"id", "img", "name"}], ?$error -->
            <div id = "profile-info" class = "bg-logo-blue-light">
              <div class="row border-bottom border-bottom-5 p-2 profile-info">
                <div class="col-2"><img src="<?= $user['img']?>" width="100%" class="rounded-1"></div>
                <div class="col-10" id = "profile-not-editing" <?= empty($error) ? "" : "style='display: none;'"?>>
                  <h2><?= $user["name"] ?></h2>
                  <p><?= $user["text"] ?></p>
                  <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div class="col-10" <?= !empty($error) ? "" : "style='display: none;'"?> id = "profile-editing">
                  <form method = "post" action = "/sharetf/public/index.php/User/updateProfile" enctype="multipart/form-data">
                  <h2><?= $user["name"] ?></h2>
                  <textarea class="form-control mb-1" name = "text"><?= empty($error) ? $user["text"] : set_value('text') ?></textarea>
                  <label for="edit-photo" class="form-label">Ukoliko želite da promenite sliku, odaberite fajl:</label>
                  <input type="file" class="form-control mb-2" id="edit-photo" name = "img">
                  <input type="submit" class="btn btn-secondary" value = "Sačuvaj">
                  <button type="button" class="btn btn-secondary" id = "edit-back-button">Nazad</button>
                  <div class = "form-text text-danger"><?= empty($error) ? "" : $error ?></div>
                  </form>
                </div>
              </div>
            </div>
            <div class = "row">
                <div class="col-3 border-end border-end-1 pe-5 bg-light" id = "profile-groups">
                    <h4 class = "my-3">Grupe</h4>
                </div>
                <div class="col-8 ps-5" id="posts">
                    <h4 class = "my-3">Objave</h4>
                </div>
            </div>
        </div>
        <script src = "/sharetf/public/scripts/elements.js"></script>
        <script src = "/sharetf/public/scripts/postLoader.js"></script>
        <script>
            groups = [
              <?php 
                for ($i = 0; $i < count($groups); $i++) {
                  echo("{
                    id: {$groups[$i]['id']},
                    img: '{$groups[$i]['img']}',
                    name: '{$groups[$i]['name']}'
                  }");
                  if ($i != count($groups) - 1) echo ",";
                }
              ?>
            ];
            $(document).ready(function() {
              $("#profile-not-editing i").click(function() {
                $("#profile-not-editing").hide();
                $("#profile-editing").show();
              });
              $("#edit-back-button").click(function() {
                $("#profile-not-editing").show();
                $("#profile-editing").hide();
              });
              for (let i = 0; i < groups.length; i++) $("#profile-groups").append(makeGroupCard(groups[i]));
              loadMorePosts(makePostWithGroup);
              $(window).scroll(function() {
                loadMorePosts(makePostWithGroup);
              })
            })
        </script>
        </body>
</html>