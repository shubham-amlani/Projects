<?php
function checkFollow($follower_id, $followed_id){
    include '_dbconnect.php';
    $sql = "SELECT * FROM `followers` WHERE `follower_user_id`=? AND `followed_user_id`=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $follower_id, $followed_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $stmt->close();
        return true;
    }
    else{
        $stmt->close();
        return false;
    }
}
?>