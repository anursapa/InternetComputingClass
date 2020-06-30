<?php
include "dbconnect.php";
include "header.inc.php";
$_SESSION['login'] = 'signup';
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
?>
<div class="container">
    <div class="row">
        <div class="col-sm">
        </div>
        <div class="col-sm">
            <form class="form-signin"  method="POST">
                <div class="text-center mb-4">
                    <?php
                    if($_SERVER['HTTP_REFERER']=="http://localhost/scratch/register.php"){
                        echo "<p>You successfully registered. Please log in</p>";
                    } else{
                        echo '<p>Please sign in if you already have an account, if not then <a href="signup.php">SIGNUP</a> </p>';
                    }
                    ?>
                </div>

                <div class="form-label-group">
                    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
                    <label for="inputEmail"></label>
                </div>

                <div class="form-label-group">
                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
                    <label for="inputPassword"></label>
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
        </div>
        <div class="col-sm">
        </div>
    </div>
</div>

<?php include "footer.inc.php"; ?>
