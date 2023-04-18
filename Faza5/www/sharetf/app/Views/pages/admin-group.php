<!-- ?$errors, $success -->
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-12 pt-3">
                            <h2>Kreiranje grupe</h2>
                            <p>Da biste kreirali novu grupu, popunite formu. Slika i naziv su obavezna polja.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?php if ($success) { ?>
                            <div id = "success" class="alert alert-success" role="alert">
                                Grupa je uspešno napravljena!
                            </div>
                            <?php } ?>
                            <form method = "post" action = "/sharetf/public/index.php/Admin/addGroup" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="admin-group-name" class="form-label">Naziv grupe</label>
                                    <input type="text" class="form-control" id="admin-group-name" placeholder="Npr. Veb Dizajn (13S113VD)" name = "name" value="<?= $success ? "" : set_value('name') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="register-name" class="form-label">Opis</label>
                                    <textarea class="form-control" id="admin-group-text" name = "text"><?= $success ? "" : set_value('text') ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="register-image" class="form-label">Slika</label>
                                    <input class="form-control" type="file" id="admin-group-image" name = "img">
                                </div>
                                <div id="admin-group-error" class="form-text text-danger">
                                    <?php 
                                        $line = false;
                                        if (!empty($errors['name'])) { echo $errors['name']; $line = true; }
                                        if (!empty($errors['img'])) {
                                            if ($line) echo "</br>";
                                            echo $errors['img'];
                                        }
                                    ?>
                                </div>
                                <input type="submit" class="btn btn-primary" id = "admin-group-button" value = "Kreiraj">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-3 bg-logo-blue-light">

                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
              $("form").submit(makeGroup)
            })
            function makeGroup(event) {
              $("#admin-group-error").html("");
              let name = $("#admin-group-name").val();
              let text = $("#admin-group-text").val();
              let img = $("#admin-group-image").val();
              if (name == "" || img == "") $("#admin-group-error").html("Slika i naziv su obavezna polja!");
              else return;
              event.preventDefault();
            }
        </script>
        </body>
</html>