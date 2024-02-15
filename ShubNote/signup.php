<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>shubNote - Dump you thoughts</title>
    <?php include 'partials/_styles.php'?>
</head>

<body>
    <?php include 'partials/_navbar.php';?>
    <h1 class="text-center p-4">Signup to shubNote</h1>
    <div class="container mb-4">
        <form>
            <div class="mb-3">
                <label for="signupEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="signupEmail" name="signupEmail"
                    placeholder="example@mail.com" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                    placeholder="Create a username, its unique to you" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Create a strong password">
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword"
                    placeholder="Confirm your password">
            </div>
            <button type="submit" class="btn btn-primary">Signup</button><br>
            <span class="mt-3 d-block">Already have an account? <a href="login.php">Login here</a></span>
        </form>
    </div>
    <div class="empty height-xs"></div>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>