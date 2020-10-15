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
        $current_lab_table = "Lab1";
        $student_id_column = "student_id";
        $lab_question_column = "lab_question";
        $difficulty_column = "x_value";
        $interest_column = "y_value";
        # example variable - will be set by login page
        $current_student_id = "mholcomb1";
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

            # read posted values
            $grid_x_value = $_POST["x_value"];
            $grid_y_value = $_POST["y_value"];
            $current_question = $_SESSION["current_question"];

            # update record with values from grid
            $update = "UPDATE $current_lab_table SET $difficulty_column=$grid_x_value, $interest_column=$grid_y_value WHERE $student_id_column='$current_student_id' AND $lab_question_column=$current_question";
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
                echo "<br>Entry update failed";
            }
        }
    ?>
</body>
</html>