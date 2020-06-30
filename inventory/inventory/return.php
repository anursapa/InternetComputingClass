<?php
  session_start();
  if (!isset($_SESSION['user'])){
    header("Location: login.php");

  }
  include "dbconnect.php";
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Inventory management system</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <script src="js/bootstrap.js" charset="utf-8"></script>
</head>
<body>
<?php include_once "header.inc.php" ?>
  <main role="main" class="container">
    <div class="jumbotron">
      <h1>Returun equipment</h1>
      <p class="lead">Please enter GWID to retrieve data info on university member to return equipment</p>
    <form class="" method="post">

    <input type="submit" name="submit" value="Submit"></a> <input type="text" name="user" value=""></form>
    <?php

    if(isset($_POST['submit'])) {
      $sql = "Select * from users where gwid='". $_POST['user'] ."'";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        $_SESSION['userLoaningGid'] = $_POST['user'];
       // output data of each row
       while($row = mysqli_fetch_assoc($result)) {
            $_SESSION['userReturnID'] = $row['id'];
            $_SESSION['idD'] = $row['id'];
           echo "<a href='returnitems.php'>".$row["firstname"] ." ". $row["lastname"]."</a>";
            $_SESSION['userLoaningName'] = $row["firstname"] ." ". $row["lastname"];}

         } else {
             echo "There is nothing";
   }

      mysqli_close($conn);
    }?>
  </div>
</main>

</body>
</html>
