<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="login-style.css">
    <title>New Login</title>
    <?php
        # database credentials
        $server = "localhost";
        $username = "root";
        $password = "Singapore47";
        $database = "jcurtis6";
        # database variables - will be established by database team
        $students_table = "Students";
        $student_id_column = "student_id";
        $crn_column = "crn";
        $student_password_column = "password";
        $teachers_table = "Teachers";
        $teacher_id_column = "teacher_id";
        $teacher_password_column = "password";
    ?>
</head>
<body>
    <div class="login">
        <div class="login_right" style="text-align: center;">
            <?php
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    # read in data from form
                    $student_id = $_POST['student_id'];
                    $teacher_password = $_POST['teacher_password'];
                    $crn = $_POST['crn'];
                    $new_password = $_POST['new_password'];
                    # connect to database
                    $conn = new mysqli($server, $username, $password, $database);
                    if($conn->connect_error){
                        die("Connection Failed");
                    }
                    # fetch teacher data
                    $stmt = $conn->prepare("SELECT $teacher_password_column FROM $teachers_table WHERE $crn_column=?");
                    $stmt->bind_param('s', $crn);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows > 0){
                        $fetch = $result->fetch_assoc()[$teacher_password_column];
                        # verify teacher password
                        if($fetch != $teacher_password){
                            echo "Incorrect Teacher Password";
                            echo "<br><br><a href='new-login.html'>Return to First Time Login Screen</a>";
                            exit;
                        }
                    }else{
                        echo "CRN Not Recognized";
                        echo "<br><br><a href='new-login.html'>Return to First Time Login Screen</a>";
                        exit;
                    }
                    # fetch student data
                    $stmt = $conn->prepare("SELECT $crn_column, $student_password_column FROM $students_table WHERE $student_id_column=?");
                    $stmt->bind_param('s', $student_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows > 0){
                        $fetch = $result->fetch_assoc();
                        # verify crn
                        if($crn != $fetch[$crn_column]){
                            echo "Invalid CRN";
                            echo "<br><br><a href='new-login.html'>Return to First Time Login Screen</a>";
                            exit;
                        }
                        # verify password already created
                        if($fetch[$student_password_column] != NULL){
                            echo "Password Already Created";
                            echo "<br><br><a href='login.html'>Go To Login Screen</a>";
                            exit;
                        }
                    }else{
                        echo "Student ID Not Recognized";
                        echo "<br><br><a href='new-login.html'>Return to First Time Login Screen</a>";
                        exit;
                    }
                    # if everything is correct, update database with new password
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