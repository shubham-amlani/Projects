<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("Location: index.php");
}

if($_SERVER['REQUEST_METHOD']=='GET'){
    include 'partials/_dbconnect.php';
    include 'partials/_sessionVars.php';
    $post_id = $_GET['postid'];
    $sql = "SELECT * FROM `posts` WHERE `post_id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $timestamp = strtotime($row['created']);
            $formattedDate = date("jS M Y h:i A", $timestamp);
            $post_title = $row['post_title'];
            $post_description = $row['post_description'];
            $post_user_id = $row['post_user_id'];
            $sql_getuser = "SELECT * FROM `users` WHERE `user_id`=?";
            $stmt_getuser = $conn->prepare($sql_getuser);
            $stmt_getuser->bind_param('i', $post_user_id);
            $stmt_getuser->execute();
            $result_getuser = $stmt_getuser->get_result();
            $row_getuser = $result_getuser->fetch_assoc();
            $post_username = $row_getuser['username'];  
            $is_private = $row['is_private'];
            if($is_private == '1'){
                $visiblity = 'private';
                if(!isset($_SESSION['loggedin'])){
                    header("Location: index.php");
                }
                else{
                    if($_SESSION['user_id'] != $post_user_id){
                        header("Location: home.php");
                    }
                }
            }
            else{
                $visiblity = 'public';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit a post</title>
    <?php include 'partials/_styles.php';?>
</head>

<body>
    <?php include 'partials/_navbar.php';?>
    <div class="container my-4 p-4 m-auto bg-secondary-subtle ">
        <h1 class="">Edit this post</h1>
        <ul>
            <li>Be civil. Don't post anything that a reasonable person would consider offensive, abusive, or hate
                speech.</li>
            <li>Keep it clean. Don't post anything disrespectful or explicit.
                Respect each other.</li>
            <li>Don't harass or grief anyone, impersonate people, or expose their private information.</li>
            <li>Respect our platform.</li>
        </ul>
        <form action="handlers/_handleEditPost.php" method="post">
            <input type="hidden" name="postid" value="<?php echo $post_id?>">
            <div class="mb-3">
                <label for="postTitle" class="form-label">Post title</label>
                <input type="text" class="form-control" id="postTitle" name="postTitle">
            </div>
            <div class="mb-3">
                <label for="postDescription" class="form-label">Post description</label>
                <textarea class="form-control" id="postDescription" name="postDescription"
                    style="height: 200px"></textarea>
            </div>
            <hr>
            <p>Visiblity</p>
            <select name="visiblity" id="visiblity" class="form-select">
                <option value="select">Choose who can see this post</option>
                <option value="public" <?php if($visiblity == 'public'){
                    echo 'selected';
                }?>>Public (anyone can see)</option>
                <option value="private" <?php if($visiblity == 'private'){
                    echo 'selected';
                }?>>Private (only you can see)</option>
            </select>
            <button type="submit" class="btn btn-success mt-4">Save changes</button>
        </form>
    </div>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
    <script>
    let postTitle = document.getElementById('postTitle');
    let postDescription = document.getElementById('postDescription');
    let postTitleValue = '<?php echo $post_title?>';
    postTitle.value = postTitleValue;
    postDescription.value = <?php echo '`'.$post_description.'`'?>;
    </script>
</body>

</html>