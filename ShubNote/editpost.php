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
        <form>
            <div class="mb-3">
                <label for="postTitle" class="form-label">Post title</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                    value="username">
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Post description</label>
                <textarea class="form-control" id="comment" name="comment" style="height: 100px"></textarea>
            </div>
            <hr>
            <p>Visiblity</p>
            <select name="visiblity" id="visiblity" class="form-select">
                <option value="select">Choose who can see this post</option>
                <option value="public">Public (anyone can see)</option>
                <option value="followers">Followers only (only your followers can see)</option>
                <option value="private">Private (only you can see)</option>
            </select>
            <button type="submit" class="btn btn-success mt-4">Post to shubNote</button>
        </form>
    </div>
    <?php include 'partials/_footer.php';?>
    <?php include 'partials/_scripts.php';?>
</body>

</html>