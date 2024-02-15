<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>shubNote - Dump you thoughts</title>
    <?php include 'partials/_styles.php'?>
    <style>
    </style>
</head>

<body class="d-flex flex-column vh-100">
    <?php include 'partials/_navbar.php';?>
    <div class="container d-flex flex-column align-items-center">
        <p class="fs-5">Its free to join, signup below and get started</p>
        <div>
            <button class="btn btn-success"><a href="login.php" class="nav-link">Login</a></button>
            <button class="btn btn-primary"><a href="signup.php" class="nav-link">Signup</a></button>
        </div>
    </div>
    <div class="main container bg-secondary-subtle my-4 p-4">
        <h1 class="">[ Welcome to shubNote ]</h1>
        <div class="p-2 word-wrap">
            <p class="text fs-5">The <b>shubNote</b> is your one-stop destination for sharing your thoughts, ideas,
                and
                experiences
                with the
                world. Whether you're looking to express yourself through blogs, jot down personal notes, or share
                snippets
                of code, you've come to the right place.</p>

            <p class="text fs-5">At <b>shubNote</b>, we believe in providing a platform where you can freely express
                yourself without limitations. Whether you want to keep your content <b>private</b> for personal
                reference
                or share
                it with the world, the choice is yours.</p>

            <p class="text fs-5">So, go ahead, create your profile, and start sharing your unique
                perspective with our
                community. We can't wait to see what you have to say!</p>
        </div>

    </div>
    <div class="empty height-sm"></div>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>