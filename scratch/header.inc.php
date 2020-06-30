<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Arsultan Nursapa - The site is under reconstraction</title>
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/sticky-footer/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>

<body>
<div class="wrapper">
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
            <a class="nav-link" href="#"><img src="img/dota-logo.png" width="30" height="30" alt=""> Dota 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"></a>
        </li>
      <li class="nav-item">
        <a class="nav-link"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><img src="img/lol-logo.png" width="30" height="30" alt=""> League of Legends</a>
      </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </li>
    </ul>
<?php
if (isset($_SESSION['user'])){
    echo 'Logged in as ' . $_SESSION["user"] . '&nbsp';
     echo ' <a href="logout.php"><button class="btn btn-outline-dark" type="submit">Log out</button></a>';
} else{
    echo '<a href="login.php"><button class="btn btn-outline-dark" type="submit">Sign in</button></a>';
}
?>
  </div>
</nav>
    <main role="main" class="flex-shrink-0">