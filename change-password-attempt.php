<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="login-style.css">
    <title>Change Password</title>
    <?php
        session_start();
        # database credentials
        $db_server = $_SESSION['db_server'];
        $db_username = $_SESSION['db_username'];
        $db_password = $_SESSION['db_password'];
        $db_database = $_SESSION['db_database'];
        # database variables
        $students_table = $_SESSION['students_table'];
        $student_id_column = $_SESSION['student_id_column'];
        $student_password_column = $_SESSION['student_password_column'];
    ?>
</head>
<body>
    <div class="login">
        <div class="login_right">
            <div class="splash">
                <?php
                    if($_SERVER["REQUEST_METHOD"] == "POST"){
                        # read password from form
                        $new_password = $_POST['new_password'];
                        # read student id from session
                        $student_id = $_SESSION['student_id'];
                        # connect to database
                        $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
                        if($conn->connect_error){
                            die("Connection Failed");
                        }
                        # update database with new password
                        $stmt = $conn->prepare("UPDATE $students_table SET $student_password_column=? WHERE $student_id_column=?");
                        $stmt->bind_param('ss', $new_password, $student_id);
                        $stmt->execute();
                        if($stmt->error){
                            echo "Unable to create password for " . $student_id;
                            echo "<br><br><a href='login.php'>Try Again</a>";
                            exit;
                        }else{
                            echo "Successfully created password for " . $student_id;
                            echo "<br><br><a href='login.php'>Login to RateMyLab</a>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>