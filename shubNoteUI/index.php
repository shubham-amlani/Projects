<?php 
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to shubNote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/_closedTemplate.css">
    <link rel="stylesheet" href="css/_utils.css">
    <link rel="stylesheet" href="css/_custom.css">
    <style>
    body {
        font-family: "Ubuntu", sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    .btn-c {
        display: inline-block;
        padding: 8px 20px;
        margin: 10px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-login {
        background-color: #4caf50;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .main {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
        text-align: left;
        max-width: 800px;
        margin: 20px auto;
        padding: 30px;
    }

    .main h1 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
    }

    .main p {
        font-size: 16px;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .highlight {
        font-weight: bold;
        color: #007bff;
    }

    .highlight-gr {
        font-weight: bold;
        color: #4caf50;
    }
    </style>
</head>

<body>
    <div class="height d-flex flex-column justify-content-center">
        <div class="container text-center">
            <h1>[ Welcome to <span class="highlight">shubNote ]</span></h1>
            <p>It's free to join. Signup below and get started.</p>
            <div>
                <a href="login.php" class="btn-c btn-login">Login</a>
                <a href="signup.php" class="btn-c">Signup</a>
            </div>
        </div>
        <div class="main text-center">
            <h2>What is <span class="highlight">shubNote</span>?</h2>
            <p>
                Your go-to platform for storing code, notes, and journal entries. Keep it <span
                    class="highlight">private</span> or <span class="highlight">share it</span> with
                friends,
                all securely <span class="highlight-gr">encrypted</span>.
            </p>
            <h2>Join Us Today!</h2>
        </div>
    </div>
    <?php include 'partials/_footer.php' ?>
</body>


</html>