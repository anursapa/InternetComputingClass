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
     <script src="js/print.js" charset="utf-8"></script>
   </head>
   <body>

     <?php include_once "header.inc.php";?>
     <a href="javascript:void(0);" onclick="printPageArea('printDiv')"><input type="submit" name="print" value="Print"></a>
<div id="printDiv">     <h3>Return form</h3>
     <p>I ,<?php echo "<em>".$_SESSION['userLoaningName']."</em>" ?>, want to return following equipment:</p><ul>
<?php

     if(!empty($_POST['checkList'])){

// Loop to store and display values of individual checked checkbox.
        foreach($_POST['checkList'] as $selected){
            echo "<li>".$selected."</li>";
            $sqlId="Select * from equipment where name='".$selected."'";
            $resultId = mysqli_query($conn, $sqlId);
            if (mysqli_num_rows($resultId) > 0) {
             // output data of each row
             while($row = mysqli_fetch_assoc($resultId)) {
               $array[]= $row['id'];
                 }
               } else {
                   echo "There is nothing";
         }

            }
            $_SESSION['itemList']=$array;
}
      if(empty($_POST['checkList'])){
            header("Location: equipmentlist.php");
}

     ?>

   </ul>
   <form class="" method="POST">

   <p>I return the equipmet undamaged and in good condition</p>
   <p>The condition remains the same as it was when I loaned it</p>
<p>Sign here: _________________</p>
<input type="submit" name="sign" value="Submit">
</form>
</div>


<?php
@$date = date('Y-m-d H:i:s');
if(isset($_POST['sign'])) {
  echo "<script type='text/javascript'>alert('Equipment loaned');</script>";
  foreach($_SESSION['itemList'] as $item){
      $sql1="update equipment set status='available' where id='".$item."'";
      // $sql2="insert into loan (time,equipment_id,user_id,returned) values ('".$date."', ".$item.", ".$_SESSION['idD'].", 1)";
      $sql2 = "update loan set returned = 1 where equipment_id='".$item."'";
      $result = mysqli_query($conn, $sql1);
      $result2 = mysqli_query($conn, $sql2);
}

  echo '<br><a href="index.php"><input type="submit" value="Go to Home page"></a>';

}?>
   </body>
   </html>