<!-- $requests = [{"id", "name", "img", "text"}] -->
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="row">
                        <div class="col-12 pt-3">
                            <h2>Zahtevi za prijateljstvo</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id = "requests-list">

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12 bg-logo-blue-light">

                </div>
            </div>
        </div>
        <script src = "/sharetf/public/scripts/elements.js"></script>
        <script>
            var baseURL = '<?= site_url() ?>';
            requests = [
              <?php
                for ($i = 0; $i < count($requests); $i++) {
                  echo("{
                    id: {$requests[$i]['id']},
                    img: '{$requests[$i]['img']}',
                    name: '{$requests[$i]['name']}',
                    text: '{$requests[$i]['text']}'
                  }");
                  if ($i != count($requests) - 1) echo ",";
                }
              ?>
            ];
            $(document).ready(function() {
              for (let i = 0; i < requests.length; i++) $("#requests-list").append(makeRequestPreview(requests[i]));
            });
        </script>
        </body>
</html>