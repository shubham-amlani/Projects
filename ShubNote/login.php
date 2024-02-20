<?php
session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    header("Location: myaccount.php");
}
$showVerificationMessage = false;
$showLoginError = false;
if(isset($_SESSION['isverified']) && $_SESSION['isverified']==true){
    $showVerificationMessage = true;
}

if(isset($_SESSION['loginError'])){
    $showLoginError = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>shubNote - Dump you thoughts</title>
    <?php include 'partials/_styles.php'?>
</head>

<body class="d-flex flex-column">
    <?php include 'partials/_navbar.php' ?>
    <?php
    if($showVerificationMessage){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your email is verified, you can login now.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      unset($_SESSION['isverified']);
    }
    if($showLoginError){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Sorry! </strong>'.$_SESSION['loginError'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        unset($_SESSION['loginError']);
    }
    if(isset($_SESSION['resetPasswordMessage'])){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success! </strong>'.$_SESSION['resetPasswordMessage'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      unset($_SESSION['resetPasswordMessage']);
    }
    if(isset($_SESSION['resetPasswordError'])){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Sorry! </strong>'.$_SESSION['resetPasswordError'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      unset($_SESSION['resetPasswordError']);
    }
    ?>
    <div class="container mb-4 height">
        <h1 class="py-3">Login to shubNote</h1>
        <hr>
        <form action="handlers/_handleLogin.php" method="post">
            <div class="mb-3">
                <label for="loginEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="loginEmail" name="loginEmail" />
            </div>
            <div class="mb-3">
                <label for="loginPassword" class="form-label">Password</label>
                <input type="password" name="loginPassword" class="form-control" id="loginPassword" />
            </div>
            <button type="submit" class="btn btn-success">Login</button>
            <span class="mx-4"><a href="forgotPassword.php">Forgot password?</a></span>
            <br />
            <span class="mt-3 d-block">Do not have an account? <a href="signup.php">Signup here</a></span>
        </form>
    </div>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>