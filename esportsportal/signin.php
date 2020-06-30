<?php

include "header.inc.php";

if(isset($_POST['submit'])){

    $sql = "Select * from user_dim where UserEmail='". $_POST['email'] ."' AND UserPassword='". $_POST['password']."'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_assoc($result)) {
            $_SESSION['user'] = $row['UserName'];
        }

        header('Location: index.php');
    } else {
        echo "<script type='text/javascript'>alert('Wrong login or password. Please try again');</script>";
    }
    mysqli_close($conn);
}

echo $_SERVER['HTTP_REFERER'];
?>

<link rel="stylesheet" href="assets/css/login.css">

<section id="coaches" class="team section-bg">
    <div class="container">
<div class="section-title" data-aos="fade-up">
    <h2>Sign in form</h2>
   <?php if($_SERVER['HTTP_REFERER']=="http://18.223.20.37/projects/esportsnew/signup.php"){
    echo "<p>You successfully registered. Please sign in</p>";
    } else{
    echo '<p>Please sign in</a> </p>';
    }?>
</div>
        <div class="container" class="member" data-aos="fade-up" data-aos-delay="400">

                    <div class="row">
                        <div class="col-lg-6 col-md-8 mx-auto">

                            <!-- form card login -->
                            <div class="card rounded shadow shadow-sm">
                                <div class="card-body">
                                    <form autocomplete="off" class="form" id="formLogin" method="POST" novalidate=""
                                          role="form">

                                    <div class="form-group">
                                            <p for="email">Username</p>
                                            <input type="text" class="form-control form-control-lg rounded-0" name="email" id="uname1" required="">
                                            <div class="invalid-feedback">Oops, you missed this one.</div>
                                        </div>
                                        <div class="form-group">
                                            <p for="password">Password</p>
                                            <input type="password" class="form-control form-control-lg rounded-0"  name="password" id="pwd1" required="" autocomplete="new-password">
                                            <div class="invalid-feedback">Enter your password too!</div>
                                        </div>
                                        <div>
                                            <a class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <a href="signup.php">Don't have an account?</a>

                                            </label>
                                        </div>
                                        <button name="submit" type="submit" class="btn btn-secondary btn-lg float-right" id="btnLogin">Login</button>

                                    </form>
                                </div>
                                <!--/card-block-->
                            </div>
                            <!-- /form card login -->
                        </div>
                    </div>
        </div>
    </section><!-- End Contact Section -->

<main id="main">
    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients clients">
      <div class="container">

        <div class="row">

          <div class="col-lg-2 col-md-4 col-6">
            <a href="http://blog.dota2.com/?l=english"><img src="assets/img/dota-logo.png" class="img-fluid" alt="" data-aos="zoom-in"></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <a href="https://na.leagueoflegends.com/en-us/"><img src="assets/img/lol-logo.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="100"></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <a href="https://www.pubg.com/"><img src="assets/img/pubg-logo.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="200"></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <a href="https://blog.counter-strike.net/"><img src="assets/img/csgo-logo.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="300"></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <a href="https://www.epicgames.com/fortnite/en-US/home"><img src="assets/img/fortnite-logo.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="400"></a>
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <a href="https://playhearthstone.com/"><img src="assets/img/heartstone-logo.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="500"></a>
          </div>

        </div>

      </div>
    </section><!-- End Clients Section -->
  </main><!-- End #main -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $("#btnLogin").click(function(event) {

        //Fetch form to apply custom Bootstrap validation
        var form = $("#formLogin")

        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
        }

        form.addClass('was-validated');
    });
</script>
  <?php include_once "footer.inc.php" ?>
