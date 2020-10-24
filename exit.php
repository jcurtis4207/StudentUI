<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>RateMyLab</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="login-style.css">
</head>
<body>
    <div class="login">
        <div class="login_right" style="text-align: center;">
            <?php
                session_start();
                echo "All " . $_SESSION['total_questions'] . " Questions Rated";
                echo "<br><br>Thank you for rating the lab";
                session_unset();
                session_destroy();
            ?>
        </div>
    </div>
</body>
</html>