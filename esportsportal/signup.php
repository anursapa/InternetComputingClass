<?php

include "header.inc.php";

if(isset($_POST['submit'])){

    $sql = "Insert into user_dim(UserID, UserEmail, UserPassword, UserName, UserAddress, UserCountry, UserZip, 
UserMainGame, UserMainPosition, UserInGameUsername) VALUES (NULL, '".$_POST['email']."', '".$_POST['password']."', '".$_POST['firstName']." ".$_POST['lastName']."', 'xx', 'xx', 'xx', '".$_POST['game']."', 'mid', 'xxdota')";

    $result = mysqli_query($conn, $sql);
    header('Location: signin.php');

    mysqli_close($conn);
}
?>

<link rel="stylesheet" href="assets/css/login.css">

<section id="coaches" class="team section-bg">
    <div class="container">
<div class="section-title" data-aos="fade-up">
    <h2>Sign up form</h2>
    <p>Please sign up</p>
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
                                            <p for="firstName">First Name</p>
                                            <input type="text" class="form-control form-control-lg rounded-0" name="firstName" id="uname1" required="" >
                                            <div class="invalid-feedback">Oops, you missed this one.</div>
                                        </div>
                                        <div class="form-group">
                                            <p for="lastName">Last Name</p>
                                            <input type="text" class="form-control form-control-lg rounded-0"  name="lastName" id="uname2" required="" autocomplete="new-password">
                                            <div class="invalid-feedback">Enter last name!</div>
                                        </div>
                                        <div class="form-group">
                                            <p for="email">Email</p>
                                            <input type="text" class="form-control form-control-lg rounded-0"  name="email" id="email" required="" autocomplete="new-password">
                                            <div class="invalid-feedback">Enter email!</div>
                                        </div>
                                        <div class="form-group">
                                            <p for="game">Select Game</p>
                                            <select class="form-control form-control-lg rounded-0"  name="game" id="game" required="" autocomplete="new-password">
                                                <option value="LOL">LOL</option>
                                                <option value="Dota">Dota</option></select>
                                            <div class="invalid-feedback">Enter your game too!</div>
                                        </div>
                                        <div class="form-group">
                                            <p for="role">Select Role</p>
                                            <select class="form-control form-control-lg rounded-0"  name="role" id="role" required="" autocomplete="new-password">
                                                <option value="LOL">Player</option>
                                                <option value="Dota">Coach</option></select>
                                            <div class="invalid-feedback">Enter your role too!</div>
                                        </div>
                                        <div class="form-group">
                                            <p for="password">Password</p>
                                            <input type="password" class="form-control form-control-lg rounded-0"  name="password" id="pwd1" required="" autocomplete="new-password">
                                            <div class="invalid-feedback">Enter password too!</div>
                                        </div>
                                        <div>
                                            <a class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input">
                                                <span class="custom-control-indicator"></span>
                                                <a href="signin.php">Have an account?</a>

                                            </label>
                                        </div>
                                        <button name="submit" type="submit" class="btn btn-secondary btn-lg float-right" id="btnLogin">Sign up</button>

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
