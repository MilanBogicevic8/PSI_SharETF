<!-- ?$errors, $register = true/false, $success = true/false-->
<!DOCTYPE html>
<html>
    <head>
        <title>SharETF - Login</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
        <link href = "/sharetf/public/css/style.css" rel = "stylesheet">
    </head>
    <body class = "login">
        <div class = "row">
            <div class = "vertical-img col-md-3 col-sm-0 d-md-block d-none">
            </div>
            <div class = "horizontal-img col-12 d-md-none d-block">
            </div>
            <div class = "col-md-4 py-5 px-5 col-sm-12">
                <div id = "login">
                    <?php if ($success) { ?>
                    <div id = "success" class="alert alert-success" role="alert">
                        Zahtev za registraciju je prosleđen administratoru! Očekujte odgovor u narednih 48h.
                    </div>
                    <?php } ?>
                    <form id = "login-form" method = "post" action = "/sharetf/public/index.php/Login/login">
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="login-email" placeholder = "piggbbbbd@student.etf.bg.ac.rs" name = "logemail" value="<?= set_value('logemail') ?>">
                            <div id="login-email-error" class="form-text text-danger"><?= empty($errors['logemail']) ? '' : $errors['logemail']?></div>
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="form-label">Lozinka</label>
                            <input type="password" class="form-control" id="login-password" name = "logpassword">
                            <div id="login-password-error" class="form-text text-danger"><?= empty($errors['logpassword']) ? '' : $errors['logpassword']?></div>
                        </div>
                        <input type="submit" class="btn btn-primary" id = "login-button" value = "Login">
                    </form>
                    <p class = "mt-3">Nemate nalog? <a id = "register-link" href = "#">Pošaljite zahtev za otvaranje naloga.</a> </p>
                    <p><a id = "about-link" href = "#">O sajtu</a></p>
                </div>
                <div id = "register">
                    <form id = "register-form" method = "post" action = "/sharetf/public/index.php/Login/register" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="register-email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="register-email" placeholder = "piggbbbbd@student.etf.bg.ac.rs" name = "email" value="<?= $register ? set_value('email') : "" ?>">
                            <div id="register-email-error" class="form-text text-danger"><?= empty($errors['email']) ? '' : $errors['email']?></div>
                        </div>
                        <div class="mb-3">
                            <label for="register-name" class="form-label">Ime</label>
                            <input type="text" class="form-control" id="register-name" name = "name" value="<?= $register ? set_value('name') : "" ?>">
                        </div>
                        <div class="mb-3">
                            <label for="register-last-name" class="form-label">Prezime</label>
                            <input type="text" class="form-control" id="register-last-name" name = "lastname" value="<?= $register ? set_value('lastname') : "" ?>">
                        </div>
                        <div class="mb-3">
                            <label for="register-password" class="form-label">Lozinka</label>
                            <input type="password" class="form-control" id="register-password" name = "password">
                        </div>
                        <div class="mb-3">
                            <label for="register-password2" class="form-label">Lozinka</label>
                            <input type="password" class="form-control" id="register-password2" name = "password2">
                            <div id="register-password-error" class="form-text text-danger"><?= empty($errors['password2']) ? '' : $errors['password2']?></div>
                        </div>
                        <div class="mb-3">
                            <label for="register-image" class="form-label">Slika</label>
                            <input class="form-control" type="file" id="register-image" name = "img">
                        </div>
                        <input type="submit" class="btn btn-primary" id = "register-button" value = "Pošalji">
                        <span>&nbsp;</span>
                        <button type="button" class="btn btn-secondary" id = "register-back-button">Nazad</button>
                        <div id="register-error" class="form-text text-danger"><?php
                            if (!empty($errors)) {
                                foreach ($errors as $key => $value) {
                                    if ($key == 'email' || $key == 'password2') continue;
                                    echo $value . '</br>';
                                }
                            }
                        ?></div>
                    </form>
                </div>
                <div id="about">
                    <h2>O sajtu</h2>
                    <ul>
                        <li>
                            <h4>Koja je namena sajta?</h4>
                            <p>Sajt je namenjen studentima ETF-a, za deljenje informacija, postavljanje pitanja i druženje.</p>
                        </li>
                        <li>
                            <h4>Ko može napraviti nalog?</h4>
                            <p>Nalog mogu napraviti svi studenti ETF-a, koristeći svoju studentsku email adresu.</p>
                        </li>
                        <li>
                            <h4>Da li studenti drugih fakulteta mogu napraviti nalog?</h4>
                            <p>Sajt je za sada namenjen samo studentima ETF-a.</p>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-secondary" id = "about-back-button">Nazad</button>
                </div>
            </div>
        </div>
    </body>
    <script src = "/sharetf/public/scripts/login.js"></script>
    <script>
        var baseURL = '<?= site_url() ?>';
        $(document).ready(function() {
            <?= $register ? "switchToRegister()" : "switchToLogin()" ?>;
            $("#login-form").submit(login);
            $("#register-link").click(switchToRegister);
            $("#about-link").click(switchToAbout)
            $("#register-form").submit(register);
            $("#register-back-button").click(switchToLogin)
            $("#about-back-button").click(switchToLogin);
        })
    </script>
</html>