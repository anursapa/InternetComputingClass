<?php include_once "header.inc.php";

$sql = "Select * from coach_dim where CoachID ='".$_GET['id']."'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $coachName = $row["CoachName"];
        $coachCountry = $row["CoachCountry"];
        $coachMainGame = $row["CoachMainGame"];
        $coachMainPosition = $row["CoachMainPosition"];
        $coachInGameUsername = $row["CoachInGameUsername"];
        $coachBio = $row["CoachBio"];
        $coachExperience = $row["CoachExperience"];
        $coachPhoto = $row["CoachPhoto"];}
} else {
    echo "There is nothing to loan at the moment";
}


mysqli_close($conn); ?>

<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Coach Informtaion</h2>

      </div>

    </div>
  </section><!-- End Breadcrumbs -->

  <!-- ======= Team Section ======= -->
  <section id="coaches" class="team section-bg">
    <div class="container">

      <div class="row">

        <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
          <div class="member" data-aos="fade-up" data-aos-delay="100">
            <div class="member-img">
              <a href="signin.php"><img src="assets/img/<?php echo $coachPhoto;?>" class="img-fluid" alt=""></a>
              <div class="social">
                <a href=""><i class="icofont-twitter"></i></a>
                <a href=""><i class="icofont-facebook"></i></a>
                <a href=""><i class="icofont-instagram"></i></a>
                <a href=""><i class="icofont-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4><?php echo $coachName;?></h4>
              <span>Dota 2</span>
            </div>
          </div>
        </div>

        <div class="col-lg-5 portfolio-info">
          <h3>Detailed Information</h3>
          <ul>
            <li><strong>Field</strong>: <?php echo $coachMainGame;?></li>
            <li><strong>Years of Experience</strong>: <?php echo $coachExperience;?></li>
            <li><strong>Position</strong>: <?php echo $coachMainPosition;?></li>
            <li><strong>Personal website</strong>: <a href="#">www.example.com</a></li>
          </ul>

          <p>
              <?php echo $coachBio;?>
          </p>

        </div>
        <section id="services" class="services">
          <div class="container">
            <div class="row">

              <div class="col-lg-100 col-md-20 d-flex align-items-stretch">
                <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                  <h4 class="title"><a href="">General Availability</a></h4>
                  <p>Eastern Time (US & Canada) (ET)</p>
                  <p class="description">
                    <ul>
                      <li><strong>Monday</strong>  03:00a - 07:00p</li>
                      <li><strong>Tuesday</strong> 04:00a - 07:00p</li>
                      <li><strong>Wednesday</strong> 04:00a - 07:00p</li>
                      <li><strong>Thursday</strong> 04:00a - 07:00p</li>
                      <li><strong>Friday</strong> 04:00a - 07:00p</li>
                  </p>
                </div>
              </div>

            </div>
            </div>
          </section>
      </div>

    </div>
  </section><!-- End Team Section -->

  <!-- ======= Pricing Section ======= -->
  <section id="pricing" class="pricing">
    <div class="container">

      <div class="section-title">
        <h2>Pricing</h2>
        <p>Select one of the bundles.</p>
      </div>

      <div class="row">

        <div class="col-lg-4 col-md-6">
          <div class="box" data-aos="zoom-in-right" data-aos-delay="200">
            <h3>1 Hour Lesson Pack</h3>
            <h4><sup>$</sup>19.99<span> / hour</span></h4>
            <ul>
              <li>Free Membership</li>
              <li>Latest News Update</li>
              <li class="na">1 Hour Free Lesson</li>
              <li class="na">Priority Pass</li>
            </ul>
            <div class="btn-wrap">
                <?php if (isset($_SESSION['user'])){
                echo '<a href="payment.php" class="btn-buy">Buy Now</a>';
                } else{
                echo '<a href="signin.php" class="btn-buy">Buy Now</a>';
                }
                ?>
<!--              <a href="payment.php" class="btn-buy">Buy Now</a>-->
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
          <div class="box recommended" data-aos="zoom-in" data-aos-delay="100">
            <h3>5 Hour Lesson Pack</h3>
            <h4><sup>$</sup>17.99<span> / hour</span></h4>
            <ul>
              <li>Free Membership</li>
              <li>Latest News Update</li>
              <li>1 Hour Free Lesson</li>
              <li class="na">Priority Pass</li>
            </ul>
            <div class="btn-wrap">
                <?php if (isset($_SESSION['user'])){
                    echo '<a href="payment.php" class="btn-buy">Buy Now</a>';
                } else{
                    echo '<a href="signin.php" class="btn-buy">Buy Now</a>';
                }
                ?>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
          <div class="box" data-aos="zoom-in-left" data-aos-delay="200">
            <h3>10 Hour Lesson Pack</h3>
            <h4><sup>$</sup>15.99<span> / hour</span></h4>
            <ul>
              <li>Free Membership</li>
              <li>Latest News Update</li>
              <li>1 Hour Free Lesson</li>
              <li>Priority Pass</li>
            </ul>
            <div class="btn-wrap">
                <?php if (isset($_SESSION['user'])){
                    echo '<a href="payment.php" class="btn-buy">Buy Now</a>';
                } else{
                    echo '<a href="signin.php" class="btn-buy">Buy Now</a>';
                }
                ?>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Pricing Section -->

</main><!-- End #main -->

<?php include_once "footer.inc.php" ?>
