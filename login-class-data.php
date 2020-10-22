<?php
    # when 'submit class info' button clicked on login screen, verify teacher password and populate lab numbers

    # database credentials
    $server = "localhost";
    $username = "root";
    $password = "Singapore47";
    $database = "jcurtis6";
    # database variables - will be established by database team
    $teachers_table = "Teachers";
    $crn_column = "crn";
    $teacher_password_column = "password";
    $labs_table = "Labs";
    $lab_id_column = "lab_id";

    # fetch variables from javascript
    $crn = $_POST['crn'];
    $teacher_password = $_POST['teacher_password'];

    # connect to database
    $conn = new mysqli($server, $username, $password, $database);
    if($conn->connect_error){
        die("Connection Failed");
    }
    
    # fetch teacher info from teachers table
    $stmt = $conn->prepare("SELECT $teacher_password_column FROM $teachers_table WHERE $crn_column=?");
    $stmt->bind_param('s', $crn);
    $stmt->execute();
    $result = $stmt->get_result();
    $output = "";
    if($result->num_rows > 0){
        $fetch = $result->fetch_assoc()[$teacher_password_column];
        # verify teacher password
        if($fetch != $teacher_password){
            $output = "Teacher_Error";
            echo $output ? $output : $output;
            return;
        }
    }else{
        $output = "";
    }
    # fetch lab info from labs table
    $stmt = $conn->prepare("SELECT $lab_id_column FROM $labs_table WHERE $crn_column=?");
    $stmt->bind_param('s', $crn);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            # create one long string of lab ids separated by @s
            $output .= "$row[$lab_id_column]" . '@';
        }
    }else{
        $output = "";
    }
    $conn->close();
    echo $output ? "$output" : "Lab_Error";
?>