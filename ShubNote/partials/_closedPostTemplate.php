<!-- Closed post template -->
<?php

function printPost($username, $title, $description, $time){
    echo '<div class="post bg-secondary-subtle">
    <div class="post-header">
        <img src="images/users-vector-icon-png_260862.jpg" alt="Profile Image" class="profile-image" />
        <div class="post-details">
            <h4 class="username">'.$username.'</h4>
            <p class="post-date">'.$time.'</p>
        </div>
    </div>
    <div class="post-content">
        <h2 class="post-title">'.$title.'</h2>
        <p class="post-description">
            '.$description.'
        </p>
        <a href="#" class="read-more">Read More</a>
    </div>
</div>';
}

?>