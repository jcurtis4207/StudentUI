<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="grid-style.css?ts=<?=time()?>">
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
        $server = "localhost";
        $username = "root";
        $password = "Singapore47";
        $database = "jcurtis6";
        # database variables - will be established by database team
        $students_table = "Students";
        $student_id_column = "student_id";
        $fname_column = "first_name";
        $lname_column = "last_name";
        $labs_table = "Labs";
        $lab_id_column = "lab_id";
        $crn_column = "crn";
        $instructor_name_column = "instructor_name";
        $semester_column = "semester";
        $course_title_column = "course_title";
    ?>
    <script>
        function submitRating(){
            //Confirm dialogue before user submits rating
            var confirmation = confirm("Are you sure you want to submit this rating?\nYou cannot return to rate this question again.");
            if(confirmation == true){
                document.getElementById('output_form').submit();
            }
        }
        function skipRating(){
            var confirmation = confirm("Are you sure you want to skip this question?\nYou cannot return to rate this question again.");
            if(confirmation == true){
                // set x and y to 0 and submit form
                document.getElementById('x_value').value = 0;
                document.getElementById('y_value').value = 0;
                document.getElementById('output_form').submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div id="lab-info">
            <?php
                # connect to database
                $conn = new mysqli($server, $username, $password, $database);
                if($conn->connect_error){
                    die("Connection Failed");
                }
                # read session variables - sent from login screen
                $student_id = $_SESSION['student_id'];
                $lab_id = $_SESSION['lab_id'];
                $crn = $_SESSION['crn'];
                # fetch student info from student table
                $result = $conn->query("SELECT $fname_column, $lname_column FROM $students_table WHERE $student_id_column='$student_id' AND $crn_column=$crn");
                if($result->num_rows > 0){
                    $fetch = $result->fetch_assoc();
                    echo "<h3>Student</h3>";
                    echo "<p>" . $fetch[$fname_column] . " " . $fetch[$lname_column] . " (" . $student_id . ")</p>";
                }else{
                    header("Location: error.html");
                    exit;
                }
                # fetch lab info from lab table
                $result = $conn->query("SELECT $instructor_name_column, $course_title_column, $semester_column FROM $labs_table WHERE $lab_id_column=$lab_id AND $crn_column=$crn");
                if($result->num_rows > 0){
                    $fetch = $result->fetch_assoc();
                    echo "<h3>Lab Number</h3>";
                    echo "<p>" . $lab_id . "</p>";
                    echo "<h3>Instructor</h3>";
                    echo "<p>" . $fetch[$instructor_name_column] . "</p>";
                    echo "<h3>Course</h3>";
                    echo "<p>" . $fetch[$course_title_column] . "</p>";
                    echo "<h3>Semester</h3>";
                    echo "<p>" . $fetch[$semester_column] . "</p>";
                    echo "<h3>CRN</h3>";
                    echo "<p>" . $crn . "</p>";
                }else{
                    header("Location: error.html");
                    exit;
                }
                $conn->close();
            ?>
        </div>
        <div id="question">
            <?php
                echo "<h1>Question " . $_SESSION['current_question'] . "<br>Click on the graph at the point that best describes your opinion of today's lab</h1>";
            ?>
        </div>
        <div id="dom-table">
            <p id='Interesting'>Interesting</p>
            <p id='Easy'>Easy</p>
            <p id='Hard'>Hard</p>
            <p id='Boring'>Boring</p>

            <!-- Click to submit rating -->
            <form id="output_form" method="POST" action="grid-submit.php">
                <input type="button" id="submit-button" value="Submit Rating" onclick="submitRating()" disabled />
                <input type="button" id="skip-button" value="Skip Question" onclick="skipRating()" />
                <!-- Hidden values for javascript to pass rating -->
                <input type="hidden" name="x_value" id="x_value" value="" />
                <input type="hidden" name="y_value" id="y_value" value="" />
            </form>
        </div>
    </div>
    <!-- Grid -->
    <script src="grid-script.js"></script>
</body>
</html>
