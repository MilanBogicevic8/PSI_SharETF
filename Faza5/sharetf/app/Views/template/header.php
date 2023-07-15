<!-- $user = {"id", "type"} , $page-->
<!DOCTYPE html>
<html>
    <head>
        <title>SharETF - <?= $page ?></title>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <link href = "/sharetf/public/css/style.css" rel = "stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row header align-items-center px-3">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <a href="/sharetf/public/index.php/User/feed" id="logo"><img src="/sharetf/public/images/logo.jpg" alt=""></a>
                </div>
            </div>
            <div class="row border-bottom border-bottom-1">
                <nav class="navbar navbar-expand-md bg-light">
                    <div class="container-fluid">
                      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse justify-content-end" id="menu">
                        <ul class="navbar-nav">
                          <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/sharetf/public/index.php/User/feed">Feed</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="/sharetf/public/index.php/User/search">Pretraga</a>
                          </li>
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Nalog
                            </a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="/sharetf/public/index.php/User/profile/<?= $user["id"]?>">Moj nalog</a></li>
                              <li><a class="dropdown-item" href="/sharetf/public/index.php/User/requests">Zahtevi za prijateljstvo</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="/sharetf/public/index.php/User/logout">Logout</a></li>
                            </ul>
                          </li>
                          <?php if ($user["type"] == "A") {?>
                          <li class="nav-item dropdown" id = "admin-menu">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Admin
                            </a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="/sharetf/public/index.php/Admin/requests">Zahtevi za registraciju</a></li>
                              <li><a class="dropdown-item" href="/sharetf/public/index.php/Admin/group">Formiranje grupe</a></li>
                            </ul>
                          </li>
                          <?php }?>
                        </ul>
                      </div>
                    </div>
                  </nav>
            </div>