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
        <div class="login_right">
            <div class="splash">
                <?php
                    session_start();
                    echo "All " . $_SESSION['total_questions'] . " Questions Rated";
                    echo "<br><br>Thank You For Rating Lab " . $_SESSION['assignment_number'];
                    echo "<p><a href='login.php'>Return to Login Screen</a></p>";
                    session_unset();
                    session_destroy();
                ?>
            </div>
        </div>
    </div>
</body>
</html>