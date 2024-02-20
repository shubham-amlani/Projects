<?php
session_start();
include 'partials/_sessionVars.php';
if(!(isset($_SESSION['loggedin'])) || $_SESSION['loggedin']!=true){
    header("Location: index.php");
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'partials/_dbconnect.php';
    $bio = $_POST['bio'];
    $sql = "UPDATE `users` SET `user_bio` = ? WHERE `users`.`user_id` = ?";
    $stmt_updatebio = $conn->prepare($sql);
    $stmt_updatebio->bind_param("ss", $bio, $user_id);
    $stmt_updatebio->execute();

    if($stmt_updatebio->affected_rows > 0){
        $_SESSION['user_bio'] = $bio;
        header("Location: myaccount.php");
        exit;
    } else {
        echo "Error updating bio";
    }
    $stmt_updatebio->close();
}
?>


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
    <?php include 'handlers/_handleDisplayImage.php';?>
    <?php $img = displayUserImage($_SESSION['user_id']);?>
    <div class="container bg-secondary-subtle my-md-4 p-4 m-md-auto height">
        <!-- User profile card -->
        <div class="profile-card d-flex flex-column container">
            <div class="d-flex">
                <?php echo $img;?>
                <p class="username fs-4 my-2 "><?php echo $user_name;?></p>
            </div>
            <p class="bio my-2">
                <?php if($_SESSION['user_bio']!=NULL){
                        echo nl2br($user_bio);
                    } ?>
            </p>
            <div>
                <div class="editProfile">
                    <form action="editProfile.php" method="post">
                        <div class="mb-3">
                            <label for="bio" class="form-label">Edit your bio</label>
                            <textarea class="form-control" id="bio" name="bio"
                                style="height: 100px; width: 300px"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                    <hr>
                    <button class="btn btn-danger"><a href="deleteaccount.php" class="nav-link">Delete my
                            account</a></button>
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