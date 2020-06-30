<?php
  include "dbconnect.php";
  session_start();
  if(isset($_POST['submit'])){
    $sql = "Select * from users where email='". $_POST['email'] ."' AND password='". $_POST['password']."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
     // output data of each row
     while($row = mysqli_fetch_assoc($result)) {
       $_SESSION['user'] = $row['username'];
       }

      header('Location: index.php');
    } else {
      echo "<script type='text/javascript'>alert('Wrong login or password');</script>";
    }
    mysqli_close($conn);
  }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Inventory management system</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/floating-labels.css">
  <script src="js/bootstrap.js" charset="utf-8"></script>
</head>
<body>
<h1>Fuck it</h1>
  <form class="form-signin"  method="POST">
  <div class="text-center mb-4">
    <img class="mb-4" src="img/gwsb.png" alt="" width="272" height="272">
    <h1 class="h3 mb-3 font-weight-normal">Inventory management system</h1>
    <p>Please sign in in order to loan equipment</p>
  </div>

  <div class="form-label-group">
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
    <label for="inputEmail">Email address</label>
  </div>

  <div class="form-label-group">
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
    <label for="inputPassword">Password</label>
  </div>

  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Remember
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
  <p class="mt-5 mb-3 text-muted text-center">© Arsultan Nursapa</p>
</form>
</body>
</html>
