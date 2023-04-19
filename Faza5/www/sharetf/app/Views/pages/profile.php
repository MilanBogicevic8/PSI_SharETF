<!-- $profile = {"name", "text", "img", "id"}, $groups = [{"id", "img", "name"}], $friendstatus -->
            <div id = "profile-info" class = "bg-logo-blue-light">
              <div class="row border-bottom border-bottom-5 p-2 profile-info">
                <div class="col-2"><img src="<?= $profile['img']?>" width="100%" class="rounded-1"></div>
                <div class="col-10">
                  <h2><?= $profile['name']?></h2>
                  <p><?= $profile['text']?></p>
                  <?php 
                    if ($friendstatus == "friends") echo "<button type='button' class='btn btn-secondary' id = 'friends-button'>Raskini prijateljstvo</button>";
                    else if ($friendstatus == "requested") echo "<button type='button' class='btn btn-secondary' id = 'friends-button'>Opozovi zahtev</button>";
                    else echo "<button type='button' class='btn btn-primary' id = 'friends-button'>Dodaj prijatelja</button>";
                  ?>
                </div>
              </div>
            </div>
            <div class = "row">
                <div class="col-3 border-end border-end-1 pe-5 bg-light" id = "profile-groups">
                    <h4 class = "my-3">Grupe</h4>
                    
                </div>
                <div class="col-8 ps-5" id="profile-posts">
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
            ]
            $(document).ready(function() {
              for (let i = 0; i < groups.length; i++) $("#profile-groups").append(makeGroupCard(groups[i]));
              loadMorePosts(makePostWithGroup);
              $(window).scroll(function() {
                loadMorePosts(makePostWithGroup);
              })
              $("#friends-button").click(function() {
                window.location.href = '/sharetf/public/index.php/User/sendRequest/<?= $profile['id'] ?>';
              })
            })
        </script>
        </body>
</html>