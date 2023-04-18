<!DOCTYPE html>
<html>
    <head>
        <title>SharETF - Login</title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
        <script src = "/sharetf/public/scripts/login.js"></script>
        <link href = "/sharetf/public/css/style.css" rel = "stylesheet">
    </head>
    <body class = "login">
        <div class = "container my-5 py-5">
            <div class = "row offset-4 col-4">
                <div id = "login">
                    <form method = "post" action = "/sharetf/public/index.php/Login/login">
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="login-email" placeholder = "piggbbbbd@student.etf.bg.ac.rs" name = "email">
                            <div id="login-email-error" class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="form-label">Lozinka</label>
                            <input type="password" class="form-control" id="login-password" name = "password">
                            <div id="login-password-error" class="form-text text-danger"></div>
                        </div>
                        <input type="submit" class="btn btn-primary" id = "login-button" value = "Login">
                    </form>
                    <p>Nemate nalog? <a id = "register-link" href = "#">Pošaljite zahtev za otvaranje naloga.</a> </p>
                    <p><a id = "about-link" href = "#">O sajtu</a></p>
                </div>
                <div id = "register">
                    <form method = "post" action = "/sharetf/public/index.php/Login/register" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="register-email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="register-email" placeholder = "piggbbbbd@student.etf.bg.ac.rs" name = "email">
                            <div id="register-email-error" class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="register-name" class="form-label">Ime</label>
                            <input type="text" class="form-control" id="register-name" name = "name">
                        </div>
                        <div class="mb-3">
                            <label for="register-last-name" class="form-label">Prezime</label>
                            <input type="text" class="form-control" id="register-last-name" name = "lastname">
                        </div>
                        <div class="mb-3">
                            <label for="register-password" class="form-label">Lozinka</label>
                            <input type="password" class="form-control" id="register-password" name = "password">
                        </div>
                        <div class="mb-3">
                            <label for="register-password2" class="form-label">Lozinka</label>
                            <input type="password" class="form-control" id="register-password2" name = "password2">
                            <div id="register-password-error" class="form-text text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="register-image" class="form-label">Slika</label>
                            <input class="form-control" type="file" id="register-image" name = "img">
                        </div>
                        <input type="submit" class="btn btn-primary" id = "register-button" value = "Pošalji">
                        <span>&nbsp;</span>
                        <button type="button" class="btn btn-secondary" id = "register-back-button">Nazad</button>
                        <div id="register-error" class="form-text text-danger"></div>
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
</html>