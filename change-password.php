<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Change Password</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="login-style.css">
    <script src="change-password-script.js"></script>
</head>
<body>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            # read data from html form
            $student_id = $_POST['student_id'];
            # save to session variable
            session_start();
            $_SESSION['student_id'] = $student_id;
        }
    ?>
    <div class="login">
        <div class="login_left">
            <img src="img/gsu-logo.png" />
        </div>
        <div class="login_right">
            <h1>Change Password</h1>
            <form id="password-form" action="change-password-attempt.php" method="POST">
                <input type="hidden" name="student_id" id="student_id" value="<? $student_id ?>" />
                <p>Enter New Password</p>
                <input type="password" size="35" maxlength="30" name="new_password" id="new_password" required>
                <p>Confirm New Password</p>
                <input type="password" size="35" maxlength="30" name="confirm_password" id="confirm_password" required>
                <br><br>
                <input type="button" id="submit-button" value="Create New Password" />
            </form>
        </div>
    </div>
</body>
</html>