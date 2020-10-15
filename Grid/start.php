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
        $labs_table = "Labs";
        $lab_id_column = "lab_id";
        $crn_column = "crn";
        $total_questions_column = "total_questions";
        # example variable - will be set by login page
        $lab_id = 1;
        $crn = 12345;
        $student_id = "mhalpern1";
    ?>
</head>

<body>
    <?php
        session_start();

        # these will be setup by the login page
        $_SESSION['current_question'] = 0;
        $_SESSION['lab_id'] = $lab_id;
        $_SESSION['crn'] = $crn;
        $_SESSION['student_id'] = $student_id;

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
    ?>
</body>
</html>