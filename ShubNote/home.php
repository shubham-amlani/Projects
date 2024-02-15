<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'partials/_styles.php'?>
    <title>Home - shubNote</title>
</head>

<body>
    <?php include 'partials/_navbar.php' ?>
    <?php include 'partials/_closedPostTemplate.php' ?>
    <div class="container height">
        <h1 class="py-md-4 px-md-5 py-3 px-2">Stream of Recent Posts</h1>
        <div class="feed">
            <p class="p-4 bg-secondary-subtle fs-5">Nothing to show here</p>
            <!-- Posts will be dynamically fetched from the database -->
            <?php printPost("shubham104", "This is a title", "This is a description", "10th Feb 2024 03:45 PM");?>
        </div>
    </div>
    <?php include 'partials/_footer.php';?>

    <a href="#" class="fixed-bottom-right">Upload a Post</a>
    <?php include 'partials/_scripts.php';?>
</body>

</html>