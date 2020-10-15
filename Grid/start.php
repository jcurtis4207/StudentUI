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
        $lab_number_column = "lab_number";
        $total_questions_column = "total_questions";
        # example variable - will be set by login page
        $current_lab = 1;
    ?>
</head>

<body>
    <?php
        # this can all probably be handled by the login mechanism
        session_start();
        $_SESSION['current_question'] = 0;
        # connect to database
        $conn = new mysqli($server, $username, $password, $database);
        if($conn->connect_error){
            die("Connection Failed");
        }
        # pull number of questions from lab table
        $result = $conn->query("SELECT $total_questions_column FROM $labs_table WHERE $lab_number_column=$current_lab");
        if($result->num_rows > 0){
            $_SESSION['total_questions'] = $result->fetch_assoc()[$total_questions_column];
        }
        header("Location: grid.php");
        exit;
    ?>
</body>
</html>