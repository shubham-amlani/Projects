<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("Location: index.php");
}
include 'partials/_dbconnect.php';
$sql_fetch_users = "SELECT * FROM `users`";
$stmt_fetch_users = $conn->prepare($sql_fetch_users);
$stmt_fetch_users->execute();
$result = $stmt_fetch_users->get_result();
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
    <?php include 'partials/_userTemplateExplore.php';?>
    <?php include 'partials/_checkFollow.php'?>
    <?php include 'handlers/_handleDisplayImage.php'?>
    <div class="container height">
        <h1 class="m-2">Explore</h1>
        <hr>
        <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $user_id = $row['user_id'];
                $username = $row['username'];
                $user_bio = $row['user_bio'];
                printUser($user_id, $username, $user_bio);
            }
        }
        ?>
    </div>
    <?php include 'partials/_uploadPost.php';?>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
    </script>
</body>

</html>