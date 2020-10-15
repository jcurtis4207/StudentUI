<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="grid-style.css">
    <title>RateMyLab</title>
    <?php
        # database credentials
        $server = "localhost";
        $username = "root";
        $password = "Singapore47";
        $database = "jcurtis6";
        # database variables - will be established by database team
        $ratings_table = "Ratings";
        $lab_id_column = "lab_id";
        $crn_column = "crn";
        $student_id_column = "student_id";
        $lab_question_column = "lab_question";
        $difficulty_column = "difficulty_rating";
        $interest_column = "interest_rating";
    ?>
</head>

<body>
    <?php
        session_start();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            # connect to database
            $conn = new mysqli($server, $username, $password, $database);
            if($conn->connect_error){
                die("Connection Failed");
            }

            # read posted values and session variables
            $grid_x_value = $_POST['x_value'];
            $grid_y_value = $_POST['y_value'];
            $current_question = $_SESSION['current_question'];
            $student_id = $_SESSION['student_id'];
            $lab_id = $_SESSION['lab_id'];
            $crn = $_SESSION['crn'];

            # update record with values from grid
            $update = "UPDATE $ratings_table SET $difficulty_column=$grid_x_value, $interest_column=$grid_y_value WHERE $lab_id_column=$lab_id AND $crn_column=$crn AND $student_id_column='$student_id' AND $lab_question_column=$current_question";
            echo $update;
            if($conn->query($update) === TRUE){
                $conn->close();
                # using javascript alerts for testing purposes
                echo '<script>alert("Successfully Updated Entry")</script>';
                echo '<script>window.location="grid.php"</script>';
                # when finalized, just use php redirect to rate next question
                #header("Location: grid.php");
                #exit;
            }else{
                $conn->close();
                header("Location: error.html");
                exit;
            }
        }
    ?>
</body>
</html>