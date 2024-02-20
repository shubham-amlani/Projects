<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_navbar.php'?>
    <div class="container m-4 p-4 m-auto">
        <h1>Forgot your password?</h1>
        <hr>
        <h3>Request a reset</h3>
        <form action="handlers/_handleForgotPassword.php" method='post'>
            <div class="mb-3">
                <label for="email" class="form-label mx-1 mx-md-0">Email address</label>
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="Enter your email address" />
            </div>
            <button class="btn btn-primary" type="submit">Reset my password</button>
        </form>
        <hr>
        <p>If an account exists with this email, a reset link will be sent to you.</p>
        <hr class="mb-1">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>