<?php
// Function to display user's uploaded image
function displayUserImage($user_id) {
    // Include database connection
    include 'partials/_dbconnect.php';

    // Prepare SQL statement to fetch image path
    $sql = "SELECT `image_path` FROM `users` WHERE `user_id` = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the user ID parameter
    $stmt->bind_param("i", $user_id);

    // Execute the SQL statement
    $stmt->execute();

    // Bind the result variable
    $stmt->bind_result($image_path);

    // Fetch the result
    $stmt->fetch();

    // Close the prepared statement
    $stmt->close();
    
    if ($image_path) {
        return '<img src="'.$image_path.'" alt="Profile Image" class="profile-image" />';
    }
    else{
        return '<img src="images/user-default.avif" alt="Profile Image" class="profile-image d-inline" />';
    }
}
?>