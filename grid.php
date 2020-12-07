<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="grid-style.css?ts=<?=time()?>">
    <script src="grid-script.js"></script>
    <title>RateMyLab</title>
    <?php
        # check if current question is more than total number of questions
        # if so exit, if not rate the question
        session_start();
        $_SESSION['current_question'] = $_SESSION['current_question'] + 1;
        if($_SESSION['current_question'] > $_SESSION['total_questions']){
            header("Location: exit.php");
            exit;
        }
        # database credentials
        $db_server = $_SESSION['db_server'];
        $db_username = $_SESSION['db_username'];
        $db_password = $_SESSION['db_password'];
        $db_database = $_SESSION['db_database'];
        # database variables
        $students_table = $_SESSION['students_table'];
        $student_id_column = $_SESSION['student_id_column'];
        $student_crn_column = $_SESSION['student_crn_column'];
        $student_fname_column = $_SESSION['student_fname_column'];
        $student_lname_column = $_SESSION['student_lname_column'];
        $teachers_table =  $_SESSION['teachers_table'];
        $semester_column = $_SESSION['semester_column'];
        $year_column = $_SESSION['year_column'];
        $teacher_id_column = $_SESSION['teacher_id_column'];
        $labs_table = $_SESSION['labs_table'];
        $lab_crn_column = $_SESSION['lab_crn_column'];
        $lab_teacher_id_column = $_SESSION['lab_teacher_id_column'];

    ?>
</head>
<body>
    <div class="container">
        <div id="lab-info">
            <?php
                # connect to database
                $conn = new mysqli($db_server, $db_username, $db_password, $db_database);
                if($conn->connect_error){
                    die("Connection Failed");
                }
                # read session variables from login screen
                $student_id = $_SESSION['student_id'];
                $assignment_number = $_SESSION['assignment_number'];
                $crn = $_SESSION['crn'];
                # fetch student info from student table
                $result = $conn->query("SELECT $student_fname_column, $student_lname_column FROM $students_table WHERE $student_id_column='$student_id' AND $student_crn_column='$crn'");
                if($result->num_rows > 0){
                    $fetch = $result->fetch_assoc();
                    echo "<h3>Student</h3>";
                    echo "<p>" . $fetch[$student_fname_column] . " " . $fetch[$student_lname_column] . " (" . $student_id . ")</p>";
                }else{
                    header("Location: error.html");
                    exit;
                }
                # fetch teacher info from lab table
                $teacher_id = '';
                $result = $conn->query("SELECT $lab_teacher_id_column FROM $labs_table WHERE $lab_crn_column='$crn'");
                if($result->num_rows > 0){
                    $fetch = $result->fetch_assoc();
                    $teacher_id = $fetch[$lab_teacher_id_column];
                }else{
                    header("Location: error.html");
                    exit;
                }
                # fetch lab info from teacher table
                $result = $conn->query("SELECT $teacher_id_column, $semester_column, $year_column FROM $teachers_table WHERE $teacher_id_column='$teacher_id'");
                if($result->num_rows > 0){
                    $fetch = $result->fetch_assoc();
                    echo "<h3>Lab Number</h3>";
                    echo "<p>" . $assignment_number . "</p>";
                    echo "<h3>Instructor</h3>";
                    echo "<p>" . $fetch[$teacher_id_column] . "</p>";
                    echo "<h3>Semester</h3>";
                    echo "<p>" . $fetch[$semester_column] . " " . $fetch[$year_column] . "</p>";
                    echo "<h3>CRN</h3>";
                    echo "<p>" . $crn . "</p>";
                }else{
                    header("Location: error.html");
                    exit;
                }
                $conn->close();
            ?>
        </div>
        <div class="main">
            <div id="question">
                <?php
                    echo "<h1>Question " . $_SESSION['current_question'] . "<br>Click on the graph at the point that best describes your opinion of today's lab</h1>";
                ?>
            </div>
            <div class="rate_question">
                <div><p id='Interesting'>Interesting</p></div>
                <div class="graph"> 
                    <div><p id='Easy'>Easy</p></div>
                    <div id="dom-table"><!-- Grid Goes Here--></div>
                    <div><p id='Hard'>Hard</p></div>
                </div>
                <div><p id='Boring'>Boring</p></div>   
            </div>
            <div class="action">
                <form id="output_form" method="POST" action="grid-submit.php">
                    <input type="button" id="skip-button" value="Skip Question" />
                    <input type="button" id="submit-button" value="Submit Rating" disabled />
                    <!-- Hidden values for javascript to pass rating -->
                    <input type="hidden" name="x_value" id="x_value" value="" />
                    <input type="hidden" name="y_value" id="y_value" value="" />
                </form>
            </div>
       </div>
    </div>
</body>
</html>
