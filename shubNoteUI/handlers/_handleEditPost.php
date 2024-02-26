<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    session_start();
    include '../partials/_sessionVars.php';
    include '../partials/_dbconnect.php';
    $post_title = $_POST['postTitle'];
    $post_description = $_POST['postDescription'];
    $visiblity = $_POST['visiblity'];
    $post_user_id = $user_id;
    $post_id = $_POST['postid'];
    if($post_title==NULL || $post_description==NULL){
        $_SESSION['postError'] = "Title or description cannot be empty";
        header("Location: ../upload.php");
    }
    else{
        if($visiblity == 'select'){
            $_SESSION['postError'] = "Please select your post visiblity";
            header("Location: ../upload.php");
        }
        else{
            if($visiblity=='public'){
                $is_private = 0;
            }
            else if($visiblity=='private'){
                $is_private = 1;
            }

            $sql = "UPDATE `posts` SET `post_title`=?,`post_description`=?, `is_private`=? WHERE `post_id`=?";
            $stmt_post = $conn->prepare($sql);
            $stmt_post->bind_param("sssi", $post_title, $post_description, $is_private, $post_id);
            $stmt_post->execute();
            if($stmt_post->affected_rows > 0){
                $_SESSION['editSuccess'] = true;
                header("Location: ../post.php?postid=$post_id");
            }
            else{
                $_SESSION['editSuccess'] = false;
                header("Location: ../post.php?postid=$post_id"); 
            }
        }
    }
}
?>