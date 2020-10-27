<?php
    # when 'submit student info' button clicked on login screen, verify student password and populate crns
    session_start();
    # database credentials
    $db_server = $_SESSION['db_server'];
    $db_username = $_SESSION['db_username'];
    $db_password = $_SESSION['db_password'];
    $db_database = $_SESSION['db_database'];
    # database variables
    $students_table = $_SESSION['students_table'];
    $student_id_column = $_SESSION['student_id_column'];
    $crn_column = $_SESSION['crn_column'];
    $student_password_column = $_SESSION['student_password_column'];
    $original_password_column = $_SESSION['original_password_column'];
    # fetch variables from javascript
    $student_id = $_POST['student_id'];
    $student_password = $_POST['student_password'];
    # connect to database
    $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
    if($conn->connect_error){
        die("Connection Failed");
    }
    # fetch student info from student table
    $stmt = $conn->prepare("SELECT $crn_column, $student_password_column, $original_password_column FROM $students_table WHERE $student_id_column=?");
    $stmt->bind_param('s', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $output = "";
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            # check if password has been changed
            if($row[$student_password_column] == NULL){
                # if not, check if original password is correct
                if($row[$original_password_column] == $student_password){
                    # need to change password
                    $output = "Change_Password";
                    break;
                }else{
                    $output = "";
                    break;
                } 
            }
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