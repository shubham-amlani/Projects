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
    <div class="container bg-secondary-subtle my-md-4 p-4 m-md-auto ">
        <!-- User profile card -->
        <div class="profile-card d-flex">
            <img src="images/users-vector-icon-png_260862.jpg" alt="Profile Image" class="profile-image " />
            <div>
                <p class="username fs-4">Username</p>
                <p class="bio">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                    eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
                <div class="editProfile">
                    <form>
                        <div class="m-0 mb-md-3">
                            <label for="email" class="form-label">Change your email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                value="email@mail.com">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Change your username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                value="username">
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Edit your bio</label>
                            <textarea class="form-control" id="comment" name="comment" style="height: 100px"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                    <hr>
                    <button class="btn btn-danger"><a href="" class="nav-link">Delete my account</a></button>
                </div>
            </div>
            <!-- Add more user information here -->
        </div>
    </div>
    <hr>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>