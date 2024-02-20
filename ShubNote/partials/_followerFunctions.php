<?php
function numFollowers($user_id){
    include 'partials/_dbconnect.php';
    $sql = 'SELECT * FROM `followers` WHERE `followed_user_id`=?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows;
}

function numFollowing($user_id){
    include 'partials/_dbconnect.php';
    $sql = 'SELECT * FROM `followers` WHERE `follower_user_id`=?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows;
}
?>