<?php
    # when 'submit student info' button clicked on login screen, verify student password and populate crns
    
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

    # fetch variables from javascript
    $student_id = $_POST['student_id'];
    $student_password = $_POST['student_password'];

    # connect to database
    $conn = new mysqli($server, $username, $password, $database);
    if($conn->connect_error){
        die("Connection Failed");
    }
    # fetch student info from student table
    $result = $conn->query("SELECT $crn_column, $student_password_column FROM $students_table WHERE $student_id_column='$student_id' ");
    $output = "";
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            # verify student password
            if($row[$student_password_column] != $student_password){
                $output = "";
                break;
            }
            # create one long string of CRNs separated by @s
            $output .= $row[$crn_column] . '@';
        }
    }else{
        $output = "";
    }
    $conn->close();
    echo $output ? "$output" : "Error";
?>