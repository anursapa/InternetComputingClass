<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Arsultan Nursapa - The site is under reconstraction</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js" charset="utf-8"></script>
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="css/footer.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <a class="navbar-brand" href="index.php"><img src="img/logo.png" width="60" height="60" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link"></a>
        </li>
        <li class="nav-item">
            <a class="nav-link"></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="https://www.gamersensei.com/senseis/searches?sort_by=relevance&page=1&game=dota-2"><img src="img/dota-logo.png" width="30" height="30" alt=""> Dota 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"></a>
        </li>
      <li class="nav-item">
        <a class="nav-link"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.gamersensei.com/senseis/searches?sort_by=relevance&page=1&game=league-of-legends"><img src="img/lol-logo.png" width="30" height="30" alt=""> League of Legends</a>
      </li>

    </ul>

      <a href="signin.php"><button class="btn btn-outline-dark" type="submit">Sign in</button></a>
  </div>
</nav>


<div class="container-fluid">
    <div class="row">

<?php include_once "sidebar.inc.php" ?>

<div id="admin-main-control" class="col-md-10 p-x-3 p-y-1">
    <div class="content-title m-x-auto">
        <i class="fa fa-dashboard"></i> Coaches
    </div>
    <p class="display-4">Available coaches</p>
    <div class="row justify-content-start">
        <div class="col-4">
            <p>Arsultan Nursapa</p>
            <img src="img/arsultan.jpg" width="100px" height="100px" alt=""></div>
        <div class="col-2">
            <p>$84.99/hour</p>
            <a href="signin.php"><button class="btn btn-outline-dark" type="submit">Book now</button></a>
        </div>
        <div class="col-4">
            <p>Kuro Salehi Takhasomi</p>
            <img src="img/KuroSalehiTakhasomi.png" width="100px" height="100px" alt=""></div>
        <div class="col-2">
            <p>$79.99/hour</p>
            <a href="signin.php"><button class="btn btn-outline-dark" type="submit">Book now</button></a>
        </div>
        </div>
        <hr>
    <div class="row justify-content-start">
        <div class="col-4">
            <p>Arteezy</p>
            <img src="img/Arteezy.png" width="100px" height="100px" alt=""></div>
        <div class="col-2">
            <p>$79.99/hour</p>
            <a href="signin.php"><button class="btn btn-outline-dark" type="submit">Book now</button></a>
        </div>
        </div>
    <hr>

    </div> <!-- /.row -->
</div> <!-- /.container-fluid -->

<?php include_once "footer.inc.php" ?>
