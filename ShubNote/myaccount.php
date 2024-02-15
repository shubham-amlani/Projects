<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <?php include 'partials/_styles.php';?>
</head>

<body>
    <?php include 'partials/_navbar.php';?>
    <div class="container bg-secondary-subtle my-md-4 p-4 m-md-auto rounded">
        <!-- User profile card -->
        <div class="profile-card d-flex">
            <img src="images/users-vector-icon-png_260862.jpg" alt="Profile Image" class="profile-image " />
            <div>
                <p class="username fs-4">Username</p>
                <p class="bio">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
                <p class="email">email@mail.com</p>
                <button class="btn btn-success"><a href="editProfile.php" class="nav-link">Edit your
                        profile</a></button>
            </div>
            <!-- Add more user information here -->
        </div>
    </div>
    <hr>
    <div class="blogs height">
        <p class="text fs-4 px-3">Your blogs</p>
    </div>
    <!-- All blogs of the user will be rendered here after fetching from database -->
    <a href="#" class="fixed-bottom-right">Upload a Post</a>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>