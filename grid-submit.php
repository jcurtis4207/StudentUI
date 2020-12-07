<?php
    # when submit or skip button clicked on grid screen, update database with grid variables
    session_start();
    # database credentials
    $db_server = $_SESSION['db_server'];
    $db_username = $_SESSION['db_username'];
    $db_password = $_SESSION['db_password'];
    $db_database = $_SESSION['db_database'];
    # database variables
    $ratings_table = $_SESSION['ratings_table'];
    $rating_crn_column = $_SESSION['rating_crn_column'];
    $assignment_number_column = $_SESSION['rating_assignment_number_column'];
    $student_id_column = $_SESSION['rating_student_id_column'];
    $lab_question_column = $_SESSION['lab_question_column'];
    $difficulty_column = $_SESSION['difficulty_column'];
    $interest_column = $_SESSION['interest_column'];
    # connect to database
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
        if($conn->connect_error){
            die("Connection Failed");
        }
        # read posted values and session variables
        $grid_x_value = $_POST['x_value'];
        $grid_y_value = $_POST['y_value'];
        $current_question = $_SESSION['current_question'];
        $student_id = $_SESSION['student_id'];
        $assignment_number = $_SESSION['assignment_number'];
        $crn = $_SESSION['crn'];
        # check if rating exists
        $check = "SELECT $difficulty_column FROM $ratings_table WHERE $rating_crn_column='$crn' AND $assignment_number_column='$assignment_number' AND $lab_question_column='$current_question' AND $student_id_column='$student_id'";
        $result = $conn->query($check);
        $stmt = '';
        if($result->num_rows > 0){
            # rating exists - update database entry
            $stmt = $conn->prepare("UPDATE $ratings_table SET $difficulty_column=?, $interest_column=? WHERE $rating_crn_column=? AND $assignment_number_column=? AND $lab_question_column=? AND $student_id_column=?");
            $stmt->bind_param('ssssss', $grid_y_value, $grid_x_value, $crn, $assignment_number, $current_question, $student_id);
        }
        else{
            # rating doesn't exist - insert grid values into database
            $stmt = $conn->prepare("INSERT INTO $ratings_table VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('ssssss', $crn, $assignment_number, $current_question, $student_id, $grid_y_value, $grid_x_value);
        }
        $stmt->execute();
        if($stmt->error){
            $conn->close();
            header("Location: error.html");
            exit;
        }else{
            $conn->close();
            # if rating successful, go to next question
            header("Location: grid.php");
            exit;
        }
    }
?>