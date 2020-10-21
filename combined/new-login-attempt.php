<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
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
            $result = $conn->query("SELECT $teacher_password_column FROM $teachers_table WHERE $crn_column=$crn");
            if($result->num_rows > 0){
                $fetch = $result->fetch_assoc()[$teacher_password_column];
                # verify teacher password
                if($fetch != $teacher_password){
                    echo "Incorrect Teacher Password";
                    echo "<br><a href='new-login.html'>Return to First Time Login Screen</a>";
                    exit;
                }
            }else{
                echo "CRN Not Recognized";
                echo "<br><a href='new-login.html'>Return to First Time Login Screen</a>";
                exit;
            }

            # fetch student data
            $result = $conn->query("SELECT $crn_column, $student_password_column FROM $students_table WHERE $student_id_column='$student_id'");
            if($result->num_rows > 0){
                $fetch = $result->fetch_assoc();
                # verify crn
                if($crn != $fetch[$crn_column]){
                    echo "Invalid CRN";
                    echo "<br><a href='new-login.html'>Return to First Time Login Screen</a>";
                    exit;
                }
                # verify password already created
                if($fetch[$student_password_column] != NULL){
                    echo "Password Already Created";
                    echo "<br><a href='login.html'>Go To Login Screen</a>";
                    exit;
                }
            }else{
                echo "Student ID Not Recognized";
                echo "<br><a href='new-login.html'>Return to First Time Login Screen</a>";
                exit;
            }

            # if everything is correct, update database with new password
            $update = "UPDATE $students_table SET $student_password_column='$new_password' WHERE $student_id_column='$student_id'";
            if($conn->query($update) === TRUE){
                echo "Successfully created password for " . $student_id;
                echo "<br><a href='login.html'>Login to RateMyLab</a>";
            }else{
                echo "Unable to create password for " . $student_id;
                echo "<br><a href='new-login.html'>Try Again</a>";
                exit;
            }
        }
    ?>
</body>
</html>