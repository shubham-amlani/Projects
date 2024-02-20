<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("Location: index.php");
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    include 'partials/_dbconnect.php';
    $query = $_GET['search'];
    
    $sql_users = "SELECT * FROM `users` WHERE MATCH (`username`) AGAINST (?)";
    $stmt_users = $conn->prepare($sql_users);
    $stmt_users->bind_param("s", $query);
    $stmt_users->execute();
    $result_users = $stmt_users->get_result();

    $sql_posts = "SELECT * FROM `posts` WHERE MATCH (`post_title`, `post_description`) AGAINST (?) AND `is_private`=0";
    $stmt_posts = $conn->prepare($sql_posts);
    $stmt_posts->bind_param("s", $query);
    $stmt_posts->execute();
    $result_posts = $stmt_posts->get_result();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php include 'partials/_styles.php';?>
</head>

<body>
    <?php include 'partials/_navbar.php';?>
    <?php include 'partials/_searchPostTemplate.php';?>
    <?php include 'partials/_searchUserTemplate.php';?>
    <?php include 'handlers/_handleDisplayImage.php';?>
    <?php include 'partials/_checkFollow.php';?>
    <div class="container height">
        <div>
            <h1>Search results</h1>
            <hr>
            <h2>Users</h2>

            <?php 
                if($result_users->num_rows > 0){
                    while($row_users = $result_users->fetch_assoc()){
                        $user_id = $row_users['user_id'];
                        $username = $row_users['username'];
                        printUser($user_id, $username, $query);
                    }
                }
                else{
                    echo '<div class="bg-secondary-subtle p-3 my-3 mx-auto container">
            <span class="fs-4">No search results</span>
            </div>';
                }
            ?>
            <hr>
        </div>
        <div>
            <h2>Posts</h2>
            <div class="postResults">
                <?php
                    if($result_posts->num_rows > 0){
                        while($row_posts = $result_posts->fetch_assoc()){
                            $sql = "SELECT `username` FROM `users` WHERE `user_id`=?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $row_posts['post_user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
    
                            $username = $row['username'];
                            $userid = $row_posts['post_user_id'];
                            $post_title = $row_posts['post_title'];
                            $post_time = strtotime($row_posts['created']);
                            $post_id = $row_posts['post_id'];
    
                            $formattedDate = date("jS M Y h:i A", $post_time);
                            printPost($username, $post_title, $formattedDate, $post_id, $userid);
                        }
                    }
                    else{
                        echo '<div class="bg-secondary-subtle p-3 my-3 mx-auto container">
            <span class="fs-4">No search results</span>
            </div>';
                    }
                ?>
            </div>
        </div>
    </div>
    <?php include 'partials/_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>