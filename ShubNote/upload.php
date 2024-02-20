<?php
session_start();
$showPostError = false;
if(!(isset($_SESSION['loggedin'])) || $_SESSION['loggedin']!=true){
    header("Location: index.php");
}
if(isset($_SESSION['postError'])){
    $showPostError = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload a post</title>
    <?php include 'partials/_styles.php';?>
</head>

<body>
    <?php include 'partials/_navbar.php';?>
    <?php
    if($showPostError){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '.$_SESSION['postError'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      unset($_SESSION['postError']);
      $showPostError = false;
    }
    ?>
    <div class="bg-secondary-subtle p-3">
        <h2>Posting as:</h2>
        <hr>
        <div class="d-flex align-items-center">
            <?php
            include 'handlers/_handleDisplayImage.php';
            $img = displayUserImage($_SESSION['user_id']);
            echo $img;
            ?>
            <div class="user-details">
                <h4 class="username"><?php echo $_SESSION['username'];?></h4>
                <p><?php echo $_SESSION['user_email']; ?></p>
            </div>
        </div>
        <hr class="mb-0">
    </div>
    <div class="container my-4 p-4 m-auto bg-secondary-subtle ">
        <h1 class="">Upload a post</h1>
        <ul>
            <li>Be respectful.</li>
            <li>Keep it clean.</li>
            <li>No harassment or impersonation.</li>
            <li>Respect our platform.</li>
        </ul>
        <form action="handlers/_handleUpload.php" method="post">
            <div class="mb-3">
                <label for="postTitle" class="form-label">Post title</label>
                <input type="text" class="form-control" id="postTitle" name="postTitle">
            </div>
            <div class="mb-3">
                <label for="postDescription" class="form-label">Post description</label>
                <textarea class="form-control" id="postDescription" name="postDescription" style="height: 400px"
                    placeholder="Start expressing it freely..."></textarea>
            </div>
            <hr>
            <p>Visiblity - Don't worry, you can change this anytime.</p>
            <select name="visiblity" id="visiblity" class="form-select">
                <option value="select">Choose who can see this post</option>
                <option value="public">Public (anyone can see)</option>
                <option value="private">Private (only you can see)</option>
            </select>
            <button type="submit" class="btn btn-success mt-4">Post to shubNote</button>
        </form>
    </div>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>