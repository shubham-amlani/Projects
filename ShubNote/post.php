<?php
session_start();
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
                if(!isset($_SESSION['loggedin'])){
                    header("Location: index.php");
                }
                else{
                    if($_SESSION['user_id'] != $post_user_id){
                        header("Location: error.php");
                        exit();
                    }
                }
            }
        }
    }
    else{
        header("Location: error.php");
        exit();
    }
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
    <?php
    if(isset($_SESSION['commentError'])){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Sorry! </strong> '.$_SESSION['commentError'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        unset($_SESSION['commentError']);
    }
    ?>
    <?php include 'partials/_searchPostTemplate.php';?>
    <?php include 'partials/_commentTemplate.php';?>
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this post?
                    </div>
                    <div class="modal-footer">
                        <form action="handlers/_handleDelete.php" method="post">
                            <input type="hidden" name="postid" value="<?php echo $post_id;?>">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" role="button" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="post bg-secondary-subtle">
            <div class="post-header">
                <?php
            include 'handlers/_handleDisplayImage.php';
            $img = displayUserImage($post_user_id);
            echo $img;
            ?>
                <div class="user-details my-2">
                    <h4 class="username"><a href="profile.php?profileid=<?php echo $post_user_id?>"
                            class="nav-link hover-ul"><?php echo $post_username;?></a></h4>
                    <b class="text-secondary"><?php echo $formattedDate;?></b>
                </div>
            </div>
            <?php
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                if($_SESSION['user_id'] == $post_user_id){
                    echo '<div class="mx-4 my-2 d-flex gap-2">
                    <button class="btn btn-primary"><a href="editpost.php?postid='.$post_id.'" class="nav-link">Edit</a></button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal">
                        Delete
                    </button>
                </div>';
                }
            }
            ?>

        </div>
        <div class="post-content height-md">
            <h2><?php echo $post_title;?></h2>
            <hr>
            <p><?php
            echo nl2br($post_description);
            ?></p>
            <hr>
        </div>

        <?php
        // Display comment box if the post is not private
        if($is_private == 0){
            echo '<div class="comments">
            <form action="handlers/_handleComments.php" method="post">
                <div class="mb-3">
                    <input type="hidden" name="post_id" value="'.$post_id.'">
                    <input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'">
                    <label for="comment_content" class="form-label">Post a comment</label>
                    <textarea class="form-control" id="comment_content" name="comment_content" style="height: 100px"
                        placeholder="Type your comment here..."></textarea>
                </div>
                <button class="btn btn-success" type="submit">Post comment</button>
            </form>
            <hr>
        </div>
        <h2>Comments</h2>';
        $sql_comments = "SELECT * FROM `comments` WHERE `comment_post_id`=?";
        $stmt_comments = $conn->prepare($sql_comments);
        $stmt_comments->bind_param('i', $post_id);
        $stmt_comments->execute();
        $result_comments = $stmt_comments->get_result();
        if($result_comments->num_rows > 0){
            while($row_comments = $result_comments->fetch_assoc()){
                $comment_id = $row_comments['comment_id'];
                $comment_user_id = $row_comments['comment_user_id'];
                $comment_content = $row_comments['comment_content'];
                $comment_time = strtotime($row_comments['timestamp']);
                $formattedDate = date("jS M Y h:i A", $comment_time);

                $sql_fetch_user = "SELECT * FROM `users` WHERE `user_id`=?";
                $stmt_fetch_user = $conn->prepare($sql_fetch_user);
                $stmt_fetch_user->bind_param("i", $comment_user_id);
                $stmt_fetch_user->execute();
                $result_fetch_uesr = $stmt_fetch_user->get_result();
                $row_fetch_user = $result_fetch_uesr->fetch_assoc();
                $comment_user_name = $row_fetch_user['username'];

                printComment($comment_id, $comment_user_id, $comment_user_name, $comment_content, $formattedDate);
            }
        }
        else{
            echo '<div class="bg-secondary-subtle p-3 my-3 mx-auto container">
            <span class="fs-4">No comments here. Be the first person to post a comment.</span>
            </div>';
        }
    }
        ?>
        <div class="my-3">Go back to <a href="profile.php?profileid=<?php echo $post_user_id;?>">user profile</a></div>

        <!-- Edit Comment Modal -->
        <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit this comment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="handlers/_handleEditComment.php" method="post">
                            <input type="hidden" name="post_id" value="<?php echo $post_id?>">
                            <input type="hidden" name="comment_id" id="comment_id">
                            <textarea class="form-control" id="editComment" name="editComment" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" role="button" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Comment Modal -->
        <div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete this comment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this comment?</p>
                        <form action="handlers/_handleDeleteComment.php" method="post">
                            <input type="hidden" name="post_id" value="<?php echo $post_id?>">
                            <input type="hidden" name="comment_id" id="delete_comment_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" role="button" class="btn btn-danger">Delete</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'partials/_uploadPost.php';?>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
    <script>
    let editBtn = document.getElementById('editCommentBtn');
    let editComment = document.getElementById('editComment');
    let commentId = document.getElementById('comment_id');
    let deleteCommentId = document.getElementById('delete_comment_id');
    let deleteBtn = document.getElementById('deleteCommentBtn');
    if (editBtn) {
        editBtn.addEventListener('click', function(e) {
            let comment_content = e.target.parentNode.previousSibling.firstChild.nextSibling.nextSibling
                .firstChild
                .innerText;
            editComment.value = comment_content;
            commentId.value = e.target.parentNode.previousSibling.firstChild.nextSibling.nextSibling.firstChild
                .getAttribute('data-commentid');
        });
    }
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function(e) {
            deleteCommentId.value = e.target.parentNode.previousSibling.firstChild.nextSibling.nextSibling
                .firstChild
                .getAttribute('data-commentid');
        });
    }
    </script>
</body>

</html>