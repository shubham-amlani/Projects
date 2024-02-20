<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['loggedin']!=true){
    header("Location: index.php");
    exit();
}
include 'partials/_dbconnect.php';
$user_id = $_SESSION['user_id'];
$sql_followed_users = "SELECT `followed_user_id` FROM `followers` WHERE `follower_user_id`=?";
$stmt_followed_users = $conn->prepare($sql_followed_users);
$stmt_followed_users->bind_param('i', $user_id);
$stmt_followed_users->execute();
$result = $stmt_followed_users->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'partials/_styles.php'?>
    <?php include 'handlers/_handleDisplayImage.php';?>
    <title>Home - shubNote</title>
</head>

<body>
    <?php include 'partials/_navbar.php'?>
    <?php include 'partials/_closedPostTemplate.php' ?>
    <div class="container height">
        <h1 class="py-md-4 px-md-5 py-3 px-2">Latest Posts by the people you follow</h1>
        <div class="feed">
            <!-- Posts will be dynamically fetched from the database -->
            <?php
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $sql_display_posts = "SELECT * FROM `posts` WHERE `post_user_id`=? AND `is_private`=0";
                    $stmt_display_posts = $conn->prepare($sql_display_posts);
                    $stmt_display_posts->bind_param('i', $row['followed_user_id']);
                    $stmt_display_posts->execute();
                    $result_display_posts = $stmt_display_posts->get_result();
                    $row_display_posts = $result_display_posts->fetch_assoc();
                if($result_display_posts->num_rows > 0){
                    while($row_display_posts = $result_display_posts->fetch_assoc()){
                        $post_id = $row_display_posts['post_id'];
                        $post_user_id = $row_display_posts['post_user_id'];
                        $post_title = $row_display_posts['post_title'];
                        $post_description = $row_display_posts['post_description'];
                        $timestamp = strtotime($row_display_posts['created']);
                        $formattedDate = date("jS M Y h:i A", $timestamp);

                        $sql_fetch_user = "SELECT `username` FROM `users` WHERE `user_id`=?";
                        $stmt_fetch_user = $conn->prepare($sql_fetch_user);
                        $stmt_fetch_user->bind_param('i', $row['followed_user_id']);
                        $stmt_fetch_user->execute();
                        $result_fetch_user = $stmt_fetch_user->get_result(); 
                        $row_fetch_user = $result_fetch_user->fetch_assoc();

                        $username = $row_fetch_user['username'];
                        printPost($post_id, $post_user_id, $username, $post_title, $post_description, $formattedDate);        
                    }
                }
                }
            }
            else{
                echo '<p class="p-4 bg-secondary-subtle fs-5">Discover and Connect: Start Following Others to Stay Updated! <a
                href="explore.php">Explore</a> here.</p>';
            }
            ?>
        </div>
    </div>
    <?php include 'partials/_footer.php';?>

    <?php include 'partials/_uploadPost.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>