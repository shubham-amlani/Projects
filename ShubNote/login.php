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
    <div class="container mb-4 height">
        <h1 class="py-3">Login to shubNote</h1>
        <hr>
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" />
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