<?php
  session_start();
  if (!isset($_SESSION['user'])){
    header("Location: login.php");

  }
  include "dbconnect.php";
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Equipment list</title>
     <link rel="stylesheet" href="css/bootstrap.css">
     <script src="js/bootstrap.js" charset="utf-8"></script>
   </head>
   <body>
     <?php include_once "header.inc.php" ?>
   </body>
   <h3>Available equipment</h3>
   <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">description</th>
      <th scope="col">Loan</th>
    </tr>
  </thead>
  <tbody>
    <form method="POST" action="loan.php">
   <?php
   $sql = "Select * from equipment where status='available'";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td> " . $row["description"]. "</td><td><input type='checkbox' name='checkList[]' value='".$row["name"].  "'></td></tr>";}
      } else {
          echo "There is nothing to loan at the moment";
}

   mysqli_close($conn);
   ?>

 </tbody>
</table>
<input type="submit" name="submit" value="Submit">
</form>
 </html>
