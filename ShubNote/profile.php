<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("Location: index.php");
}
$showFollowMessage = false;
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    include 'partials/_dbconnect.php';
    $user_id = $_GET['profileid'];
    if($_SESSION['user_id'] == $user_id){
        header("Location: myaccount.php");
    }
    $sql = "SELECT * FROM `users` WHERE `user_id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $username = $row['username'];
            $user_bio = $row['user_bio'];
        }
    }    
    else{
        header("Location: error.php");
        exit();
    }
}

if(isset($_SESSION['followMessage'])){
    $showFollowMessage = true;
    $followMessage = $_SESSION['followMessage'];
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
    <?php
    if($showFollowMessage){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Sorry !</strong> '.$followMessage.'.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        unset($_SESSION['followMessage']);
        $showFollowMessage = false;
    }
    ?>
    <div class="container bg-secondary-subtle my-md-4 p-4 m-md-auto rounded">
        <!-- User profile card -->
        <div class="profile-card d-flex">
            <?php
            include 'handlers/_handleDisplayImage.php';
            $img = displayUserImage($user_id);
            echo $img;
            ?>
            <div>
                <div class="d-flex gap-2">
                    <p class="username fs-4"> <?php echo $username;?></p>
                    <form action="handlers/_handleFollowUnfollow.php" method="post">
                        <?php
                        include 'partials/_checkFollow.php';
                        echo '<input type="hidden" name="page" value="profile.php?profileid='.$user_id.'">';
                        if(checkFollow($_SESSION['user_id'], $user_id)){
                            echo '<input type="hidden" name="unfollower_user_id" value="'.$_SESSION['user_id'].'">
                            <input type="hidden" name="unfollowed_user_id" value="'.$user_id.'">
                            <button class="btn btn-outline-secondary">Unfollow</button>';
                        }
                        else{
                            echo '<input type="hidden" name="follower_user_id" value="'.$_SESSION['user_id'].'">
                            <input type="hidden" name="followed_user_id" value="'.$user_id.'">
                            <button class="btn btn-primary">Follow</button>';
                        }
                        ?>
                    </form>
                </div>
                <p class="bio">
                    <?php echo $user_bio;?>
                </p>
            </div>
            <!-- Add more user information here -->
        </div>
        <?php 
        include 'partials/_searchPostTemplate.php';
        include 'partials/_followerFunctions.php';

        $sql = "SELECT * FROM `posts` WHERE `post_user_id`=? AND `is_private`='0'  ORDER BY `created` DESC";
        $stmt = $conn->prepare($sql);
        echo($conn->error);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_posts = $result->num_rows;

        $numFollowers = numFollowers($user_id);
        $numFollowing = numFollowing($user_id);
        ?>
        <div class="container mx-md-0 mx-auto my-3 col-md-3 col-12">
            <div class="d-flex justify-content-between">
                <div class="posts flex-item d-flex flex-column align-items-center">
                    <span>Public Posts</span>
                    <b><?php echo $num_posts;?></b>
                </div>
                <a href="followers.php?profileid=<?php echo $user_id;?>" class="nav-link hover-ul">
                    <div class="followers flex-item d-flex flex-column align-items-center">
                        <span>Followers</span>
                        <b><?php echo $numFollowers;?></b>
                    </div>
                </a>
                <div class="following flex-item d-flex flex-column align-items-center">
                    <span>Following</span>
                    <b><?php echo $numFollowing;?></b>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="height-md">
        <p class="text fs-4 px-3">Public posts</p>

        <?php
        if($num_posts > 0){
            while($row = $result->fetch_assoc()){
                $timestamp = strtotime($row['created']);
                $formattedDate = date("jS M Y h:i A", $timestamp);
                printPost($username, $row['post_title'], $formattedDate, $row['post_id'], '0');
            }
        }
        else{
            echo '<div class="container bg-secondary-subtle p-3 my-3 mx-auto container">
            <span class="fs-4">This user have no public posts.</span>
            </div>';
        }
        $stmt->close();
    ?>
    </div>
    <!-- Public blogs of the user will be rendered here after fetching from database -->
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_uploadPost.php'?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>