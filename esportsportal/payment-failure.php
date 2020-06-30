<?php include_once "header.inc.php";

$sql = "Select * from user_dim where UserName ='".$_SESSION['user']."'";

   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {
       // output data of each row
       while($row = mysqli_fetch_assoc($result)) {
           $userEmail = $row["UserEmail"];
           $mainGame = $row["UserMainGame"];}
   } else {
       echo "There is nothing to loan at the moment";
   }

   mysqli_close($conn);
?>

<main id="main">



  <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Payment</h2>
            </div>
            <br><br><br><br><br>
            <center data-aos="fade-up">
        <p>Sorry. We couldn't process your transaction</p>
        <div class="btn-wrap">
            <a href="account-info.php" class="btn-buy">Go to your account</a>            </div>


    </div>
  </section><!-- End Features Section -->
</center>

<br>
<br>
<br>
<br>
<br>

</main><!-- End #main -->

<?php include_once "footer.inc.php" ?>
