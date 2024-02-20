<?php
session_start();
if(isset($_SESSION['signupEmail'])){
    $email = $_SESSION['signupEmail'];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include 'partials/_dbconnect.php';
        $sql = "SELECT * FROM `users` WHERE `user_email`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Checking whether the entered code is same or not.
        $enteredCode = $_POST['veri_code'];
        $actualCode = $row['verification_code'];
        echo var_dump($enteredCode == $actualCode);
        if($enteredCode == $actualCode){
            $sql = "UPDATE `users` SET `is_verified` = '1' WHERE `users`.`user_email` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $_SESSION['isverified'] = true;
                header("Location: login.php");
            }
        }
    }
}

$displayLoginVerificationMessage = false;
if(isset($_SESSION['loginEmail'])){
    $displayLoginVerificationMessage = true;
    $email = $_SESSION['loginEmail'];
    echo var_dump($_SERVER['REQUEST_METHOD']);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        include 'partials/_dbconnect.php';
        $sql = "SELECT * FROM `users` WHERE `user_email`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        // Check whether entered code is same or not
        $enteredCode = $_POST['veri_code'];
        $actualCode = $row['verification_code'];
        if($enteredCode == $actualCode){
            $sql = "UPDATE `users` SET `is_verified` = '1' WHERE `users`.`user_email` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                $_SESSION['isverified'] = true;
                header("Location: login.php");
            }
        }
    }
}

if(isset($_SESSION['forgotPasswordEmail'])){
    include 'partials/_dbconnect.php';
    $email = $_SESSION['forgotPasswordEmail'];

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $sql_forgot_password = "SELECT `verification_code` FROM `users` WHERE `user_email`=?";
    $stmt_forgot_password = $conn->prepare($sql_forgot_password);
    $stmt_forgot_password->bind_param("s", $email);
    $stmt_forgot_password->execute();
    $result_forgot_password = $stmt_forgot_password->get_result();
    $row_forgot_password = $result_forgot_password->fetch_assoc();

    $dbCode = $row_forgot_password['verification_code']; 
    $entCode = $_POST['veri_code'];
    if($entCode == $dbCode){
        header("Location: resetpassword.php");
    }
}
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php include 'partials/_styles.php';?>
</head>

<body>
    <?php include 'partials/_navbar.php';?>
    <?php
    if($displayLoginVerificationMessage){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Verify!</strong> Your email is not verified, you need to verify before you login.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <div class="container p-2 height">
        <h1>Verification</h1>
        <form action="verifycode.php" method="post">
            <div class="mb-3">
                <label for="code" class="form-label">Verification code sent to your email</label>
                <input type="number" class="form-control" id="veri_code" name="veri_code"
                    placeholder="Enter your 6 digit code">
            </div>
            <button class="btn btn-primary" type="submit">Verify</button>
        </form>
    </div>
    <?php include 'partials/_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>