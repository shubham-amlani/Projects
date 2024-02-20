<?php
session_start();
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

<body class="height">
    <?php include 'partials/_navbar.php';?>
    <?php
    if(isset($_SESSION['deleteAccountError'])){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong> Error!</strong> '.$_SESSION['deleteAccountError'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      unset($_SESSION['deleteAccountError']);
    }
    ?>
    <div class="container mx-auto my-4 bg-secondary-subtle p-4">
        <h1 class="">Delete your account</h1>
        <p class="text fs-5">Are you sure you want to delete your account? Please note that this action is
            <b class="text-danger">irreversible</b>.
        </p>
        <p class="text fs-5">By deleting your account, all your account details, including follower information, posts,
            comments, and any other related data, will be <b class="text-danger">permanently removed</b> from our
            system. There will be no way to
            retrieve this information ever again.</p>
        <p class="text fs-5">If you are certain about deleting your account, please proceed. Otherwise, please go back.
        </p>
        <hr>
        <p class="text fs-5"><b>Before proceeding, please confirm the following:</b></p>
        <form action="handlers/_handleDeleteAccount.php" method="post">
            <div class="d-flex align-items-center gap-3 my-2">
                <label for="consentCheck1" class="form-check-label">I have read and agree to the terms and
                    conditions.</label>
                <input type="checkbox" name="consentCheck1" id="consentCheck1" class="form-check-input" value="delete1">
            </div>
            <div class="d-flex align-items-center gap-3 my-2">
                <label for="consentCheck2" class="form-check-label">I understand that deleting my account is
                    irreversible.</label>
                <input type="checkbox" name="consentCheck2" id="consentCheck2" class="form-check-input" value="delete2">
            </div>
            <div class="d-flex align-items-center gap-3 my-2">
                <label for="consentCheck3" class="form-check-label">I acknowledge that <b class="text-primary">all</b>
                    my
                    account data will be <b class="text-danger">permanently removed</b>.</label>
                <input type="checkbox" name="consentCheck3" id="consentCheck3" class="form-check-input" value="delete3">
            </div>
            <hr>
            <button class="btn btn-danger my-3" type="submit">Delete my account</button>
        </form>
    </div>
    <?php include 'partials/_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>