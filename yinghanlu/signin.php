<?php
session_start();
include "dbconnect.php";

if(isset($_POST['submit'])){
    $sql = "Select * from user_dim where UserEmail='". $_POST['email'] ."' AND UserPassword='". $_POST['password']."'";
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

<form class="form-signin"  method="POST">
    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
    <label for="inputEmail">Email address</label>
    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
    <label for="inputPassword">Password</label>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
</form>
<br><a href="index.php">go to main page</a>

