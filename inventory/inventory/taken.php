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
   <h3>Taken equipment</h3>
   <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">description</th>
    </tr>
  </thead>
  <tbody>
   <?php
   $sql = "Select * from equipment where status='taken'";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        //$sql2 = "select users.id, loan.equipment_id,loan.time from users INNER JOIN loan on users.id = loan.user_id WHERE returned = 0 and equipment_id=".$row['id'];
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td> " . $row["description"]. "</td></tr>";}
      } else {
          echo "There is nothing taken at the moment";
}

   mysqli_close($conn);
   ?>

 </tbody>
</table>
</form>
 </html>
