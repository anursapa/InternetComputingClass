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
   <h3>Return equipment</h3>
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
    <form method="POST" action="returnform.php">
   <?php
   $sql = "select users.id, loan.equipment_id,loan.time from users INNER JOIN loan on users.id = loan.user_id WHERE returned = 0 and users.id =" . $_SESSION['userReturnID'];

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $sql2="Select * from equipment where id=".$row['equipment_id'];
      $result2 = mysqli_query($conn, $sql2);
      while($row2 = mysqli_fetch_assoc($result2)) {
        echo "<tr><td>" . $row2["id"]. "</td><td>" . $row2["name"]. "</td><td> " . $row2["description"]. "</td><td><input type='checkbox' name='checkList[]' value='".$row2["name"].  "'></td></tr>";
      }
}
} else {echo "You have no items loaned";}
   mysqli_close($conn);
   ?>

 </tbody>
</table>
<input type="submit" name="submit" value="Return">
</form>
 </html>
