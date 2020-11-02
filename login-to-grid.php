<?php
    # pull all data from login screen, pull number of questions from database, forward to grid to start rating
    session_start();
    # database credentials
    $db_server = $_SESSION['db_server'];
    $db_username = $_SESSION['db_username'];
    $db_password = $_SESSION['db_password'];
    $db_database = $_SESSION['db_database'];
    # database variables
    $labs_table = $_SESSION['labs_table'];
    $lab_id_column = $_SESSION['lab_id_column'];
    $crn_column = $_SESSION['crn_column'];
    $total_questions_column = $_SESSION['total_questions_column'];
    # read data from html form
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $student_id = $_POST['student_id'];
        $crn = $_POST['crn_dropdown'];
        $lab_id = $_POST['lab_dropdown'];
        # setup session variables for grid
        $_SESSION['current_question'] = 0;
        $_SESSION['student_id'] = $student_id;
        $_SESSION['crn'] = $crn;
        $_SESSION['lab_id'] = $lab_id;
        # connect to database
        $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
        if($conn->connect_error){
            die("Connection Failed");
        }
        # fetch number of questions from lab table
        $result = $conn->query("SELECT $total_questions_column FROM $labs_table WHERE $lab_id_column='$lab_id' AND $crn_column='$crn'");
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