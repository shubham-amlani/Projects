<?php 
session_start();
include 'partials/_sessionVars.php';
include 'partials/_dbconnect.php';
if(!(isset($_SESSION['loggedin'])) || $_SESSION['loggedin']!=true){
    header("Location: index.php");
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
    <div class="container bg-secondary-subtle my-md-4 p-4 m-md-auto rounded">
        <!-- --------------------------------------------Modal-------------------------------------------- -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Profile picture</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="handlers/_handlePicture.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                                <label for="image" class="my-1">Please choose a profile picture</label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*"
                                    required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" role="button" class="btn btn-primary">Upload</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- User profile card -->
        <div class="profile-card d-flex">
            <?php
            include 'handlers/_handleDisplayImage.php';
            $img = displayUserImage($user_id);
            echo $img;
            ?>
            <div>
                <p class="username fs-4"><?php echo "$user_name";?></p>
                <p class="bio">
                    <?php
                    if($user_bio==NULL){
                        echo 'Click on edit profile to add your bio';
                    }
                    else{
                        echo nl2br($user_bio);
                    }
                    ?>
                </p>
                <p class="email"><?php echo $user_email ?></p>
                <button class="btn btn-success my-2 "><a href="editProfile.php" class="nav-link">Edit your
                        profile</a></button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Upload profile picture
                </button>

            </div>
        </div>
        <?php 
        include 'partials/_searchPostTemplate.php';
        include 'partials/_followerFunctions.php';

        $sql = 'SELECT * FROM `posts` WHERE `post_user_id`=? ORDER BY `created` DESC';
        $stmt = $conn->prepare($sql);
        echo($conn->error);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_posts = $result->num_rows;

        $numFollowers = numFollowers($user_id);
        $numFollowing = numFollowing($user_id);
        ?>
        <div class="container mx-md-5 mx-auto my-3 col-md-3 col-12">
            <div class="d-flex justify-content-between">
                <div class="posts flex-item d-flex flex-column align-items-center">
                    <span>Posts</span>
                    <b><?php echo $num_posts;?></b>
                </div>
                <a href="followers.php?profileid=<?php echo $user_id;?>" class="nav-link">
                    <div class="followers flex-item d-flex flex-column align-items-center">
                        <span>Followers</span>
                        <b><?php echo $numFollowers;?></b>
                    </div>
                </a>
                <a href="following.php" class="nav-link">
                    <div class="following flex-item d-flex flex-column align-items-center">
                        <span>Following</span>
                        <b><?php echo $numFollowing;?></b>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="blogs height">
        <p class="text fs-4 px-3">Your posts</p>
        <!-- All blogs of the user will be rendered here after fetching from database -->
        <?php
        if($num_posts > 0){
            while($row = $result->fetch_assoc()){
                $timestamp = strtotime($row['created']);
                $formattedDate = date("jS M Y h:i A", $timestamp);
                printPost($user_name, $row['post_title'], $formattedDate, $row['post_id'], $user_id, $row['is_private']);
            }
        }
        $stmt->close();
    ?>
    </div>



    <?php include 'partials/_uploadPost.php';?>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>