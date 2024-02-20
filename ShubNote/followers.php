<?php
session_start();
if(!isset($_GET['profileid'])){
    header("Location: home.php");
    exit();
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
        include 'partials/_dbconnect.php';
        $profile_id = $_GET['profileid'];
        $sql = 'SELECT * FROM `followers` WHERE `followed_user_id`=?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $profile_id);
        $stmt->execute();
        $result = $stmt->get_result();
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
    <style>
    </style>
</head>

<body>
    <?php include 'partials/_navbar.php';?>
    <?php include 'partials/_userTemplate.php';?>
    <?php include 'handlers/_handleDisplayImage.php';
        include 'partials/_checkFollow.php';?>
    <div class="container height">
        <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sql_list = "SELECT * FROM `users` WHERE `user_id`=?";
                $stmt_list = $conn->prepare($sql_list);
                $stmt_list->bind_param('i', $row['follower_user_id']);
                $stmt_list->execute();
                $result_list = $stmt_list->get_result();
                $row_list = $result_list->fetch_assoc();
                $username = $row_list['username'];
                $user_id = $row_list['user_id'];
                printUser($user_id, $username, $profile_id);
            }
        }
        else{
            echo '<div class="bg-secondary-subtle p-3 my-3 mx-auto container">
            <span class="fs-4">Nothing to show here</span>
            </div>';
        }

        if($_SESSION['user_id'] == $profile_id){
            echo '<div class="container mx-auto">Go back to <a href="myaccount.php">your account</a></div>';
        }
        else{
            echo '<div class="container mx-auto">Go back to <a href="profile.php?profileid='.$profile_id.'">user profile</a></div>';
        }
        ?>
    </div>
    <?php include 'partials/_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>