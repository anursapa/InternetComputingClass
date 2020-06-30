<?php include_once "header.inc.php" ?>
<?php
    session_destroy();
include "dbconnect.php";

if(isset($_POST['submit'])){
    $sql = "(`UserID`, `UserEmail`, `UserPassword`, `UserName`, `UserAddress`, `UserCountry`, `UserZip`, `UserMainGame`, `UserMainPosition`, `UserInGameUsername`) VALUES (NULL, 'test@test.com', '123456', 'Test', 'Test', 'Test', '33333', 'Dota', 'center', 'test')
Insert into user_dim where UserEmail='". $_POST['email'] ."' AND UserPassword='". $_POST['password']."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        while($row = mysqli_fetch_assoc($result)) {
            $_SESSION['user'] = $row['UserName'];
        }

        header('Location: index.php');
    } else {
        echo "<script type='text/javascript'>alert('Wrong login or password');</script>";
    }
    mysqli_close($conn);
}


?>
<div class="container-fluid">
    <div class="container">
        <h2 class="text-center" id="title">Sign up form</h2>
        <p class="text-center">
            <small id="passwordHelpInline" class="text-muted">Please sign up</small>
        </p>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <!-------null------>
            </div>

            <div class="col-md-5">
                <form role="form" method="post" action="register.php">
                    <fieldset>
                        <p class="text-uppercase pull-center"> SIGN UP.</p>
                        <div class="form-group">
                            <select name="choose game" id="game" class="form-control input-lg" placeholder="Choose game">
                                <option value="dota">Dota 2</option>
                                <option value="lol">League of Legends</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="username" id="username" class="form-control input-lg" placeholder="username">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input type="acountid" name="accountid" id="accountid" class="form-control input-lg" placeholder="Account ID">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password2" id="password2" class="form-control input-lg" placeholder="Password2">
                        </div>
                        <div class="form-group">
                            <select name="chose role" id="role" class="form-control input-lg" placeholder="Choose role">
                                <option value="coach">Coach</option>
                                <option value="Player">Player</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input">
                                By Clicking register you're agree to our policy & terms
                            </label>
                        </div>
                        <div>
                            <a href="register.php"><input type="submit" class="btn btn-outline-dark   value="Register"></a>
                        </div>
                    </fieldset>
                </form>
            </div>

        </div>
    </div>
   </div>

<?php include_once "footer.inc.php" ?>
