<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="login-style.css">
    <title>Change Password</title>
    <?php
        # database credentials
        $server = "localhost";
        $username = "root";
        $password = "Singapore47";
        $database = "jcurtis6";
        # database variables - will be established by database team
        $students_table = "Students";
        $student_id_column = "student_id";
        $student_password_column = "password";
    ?>
</head>
<body>
    <div class="login">
        <div class="login_right" style="text-align: center;">
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    # read password from form
                    $new_password = $_POST['new_password'];
                    # read student id from session
                    session_start();
                    $student_id = $_SESSION['student_id'];
                    # end session
                    session_unset();
                    session_destroy();
                    # connect to database
                    $conn = new mysqli($server, $username, $password, $database);
                    if($conn->connect_error){
                        die("Connection Failed");
                    }
                    # update database with new password
                    $stmt = $conn->prepare("UPDATE $students_table SET $student_password_column=? WHERE $student_id_column=?");
                    $stmt->bind_param('ss', $new_password, $student_id);
                    $stmt->execute();
                    if($stmt->error){
                        echo "Unable to create password for " . $student_id;
                        echo "<br><br><a href='new-login.html'>Try Again</a>";
                        exit;
                    }else{
                        echo "Successfully created password for " . $student_id;
                        echo "<br><br><a href='login.html'>Login to RateMyLab</a>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>