<?php
    # pull all data from login screen, pull number of questions from database, forward to grid to start rating
    session_start();
    # database credentials
    $db_server = $_SESSION['db_server'];
    $db_username = $_SESSION['db_username'];
    $db_password = $_SESSION['db_password'];
    $db_database = $_SESSION['db_database'];
    # database variables
    $assignments_table = $_SESSION['assignments_table'];
    $assignment_crn_column = $_SESSION['assignment_crn_column'];
    $assignment_number_column = $_SESSION['assignment_number_column'];
    $total_questions_column = $_SESSION['total_questions_column'];
    # read data from html form
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $student_id = $_POST['student_id'];
        $crn = $_POST['crn_dropdown'];
        $assignment_number = $_POST['lab_dropdown'];
        # setup session variables for grid
        $_SESSION['current_question'] = 0;
        $_SESSION['student_id'] = $student_id;
        $_SESSION['crn'] = $crn;
        $_SESSION['assignment_number'] = $assignment_number;
        # connect to database
        $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
        if($conn->connect_error){
            die("Connection Failed");
        }
        # fetch number of questions from assignments table
        $result = $conn->query("SELECT $total_questions_column FROM $assignments_table WHERE $assignment_number_column='$assignment_number' AND $assignment_crn_column='$crn'");
        if($result->num_rows > 0){
            $_SESSION['total_questions'] = $result->fetch_assoc()[$total_questions_column];
        }else{
            header("Location: error.html");
            exit;
        }
        header("Location: grid.php");
        exit;
    }
?>