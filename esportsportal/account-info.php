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

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Welcome home, <?php echo $_SESSION['user'];?>!</h2>
        <ol>
          <li><a href="account-info.php">Account Information</a></li>
          <li>Main
        </li>
        </ol>
      </div>

    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Team Section ======= -->
  <section id="coaches" class="team section-bg">
    <div class="container">

      <div class="row">

<?php include_once "sidebar.inc.php" ?>

        <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
          <div class="member" data-aos="fade-up" data-aos-delay="100">
            <div class="member-img">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="file">
                    <input type="submit" name="submit" value="Upload">
                </form>
              <img src="assets/img/upload.png" class="img-fluid" alt=""></a>

            </div>
            <div class="member-info">
              <h4><?php echo $_SESSION['user'];?></h4>
              <span></span>
            </div>
          </div>
        </div>

        <div class="col-lg-6 portfolio-info">
          <h3>Account Information</h3>
          <ul>
            <li><strong>Username</strong>: <?php echo $_SESSION['user'];?> </li>
            <li><strong>Date joined</strong>: <?php echo date("M,d,Y"); ?> </li>
            <li><strong>Email address</strong>: <?php echo $userEmail;?></li>
            <li><strong>Prefered gaming field</strong>: <?php echo $mainGame;?> </li>
          </ul>

          <p>
          </p>

        </div>

      </div>

    </div>
  </section><!-- End Team Section -->


      </div>

    </div>
  </section><!-- End Team Section -->

</main><!-- End #main -->

<?php include_once "footer.inc.php" ?>
