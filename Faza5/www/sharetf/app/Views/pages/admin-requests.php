<!-- $requests = [{"id", "name", "img", "email"}] -->
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-12 pt-3">
                            <h2>Zahtevi za registraciju</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id = "admin-requests-list">
                        </div>
                    </div>
                </div>
                <div class="col-3 bg-logo-blue-light">

                </div>
            </div>
        </div>
        <script src = "/sharetf/public/scripts/elements.js"></script>
        <script>
            requests = [
              <?php
                for ($i = 0; $i < count($requests); $i++) {
                  echo("{
                    id: {$requests[$i]['id']},
                    img: '{$requests[$i]['img']}',
                    name: '{$requests[$i]['name']}',
                    text: '{$requests[$i]['email']}'
                  }");
                  if ($i != count($requests) - 1) echo ",";
                }
              ?>
            ];
            $(document).ready(function() {
              for (let i = 0; i < requests.length; i++) $("#admin-requests-list").append(makeAdminRequestPreview(requests[i]));
            });
        </script>
        </body>
</html>