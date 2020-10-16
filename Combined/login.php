<?php
    # pull all data from login screen, pull number of questions from database, forward to grid to start rating
    
    # database credentials
    $server = "localhost";
    $username = "root";
    $password = "Singapore47";
    $database = "jcurtis6";
    # database variables - will be established by database team
    $labs_table = "Labs";
    $lab_id_column = "lab_id";
    $crn_column = "crn";
    $total_questions_column = "total_questions";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        # read data from html form
        $student_id = $_POST['student_id'];
        $crn = $_POST['crn_dropdown'];
        $lab_id = $_POST['lab_dropdown'];

        # start session and setup session variables
        session_start();
        $_SESSION['current_question'] = 0;
        $_SESSION['student_id'] = $student_id;
        $_SESSION['crn'] = $crn;
        $_SESSION['lab_id'] = $lab_id;

        # connect to database
        $conn = new mysqli($server, $username, $password, $database);
        if($conn->connect_error){
            die("Connection Failed");
        }
        # fetch number of questions from lab table
        $result = $conn->query("SELECT $total_questions_column FROM $labs_table WHERE $lab_id_column=$lab_id AND $crn_column=$crn");
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