<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Student Login</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="login-style.css">
    <script src="login-script.js"></script>
    <?php
        session_start();
        # database credentials - need to change database to official one
        $_SESSION['db_server'] = "localhost";
        $_SESSION['db_username'] = "root";
        $_SESSION['db_password'] = "Singapore47";
        $_SESSION['db_database'] = "jcurtis6";
        # database variables - will be established by database team
        $_SESSION['students_table'] = "Students";
        $_SESSION['student_id_column'] = "student_id";
        $_SESSION['fname_column'] = "first_name";
        $_SESSION['lname_column'] = "last_name";
        $_SESSION['crn_column'] = "crn";
        $_SESSION['student_password_column'] = "password";
        $_SESSION['original_password_column'] = "orig_password";
        $_SESSION['teachers_table'] = "Teachers";
        $_SESSION['teacher_password_column'] = "password";
        $_SESSION['labs_table'] = "Labs";
        $_SESSION['lab_id_column'] = "lab_id";
        $_SESSION['total_questions_column'] = "total_questions";
        $_SESSION['instructor_name_column'] = "instructor_name";
        $_SESSION['semester_column'] = "semester";
        $_SESSION['course_title_column'] = "course_title";
        $_SESSION['ratings_table'] = "Ratings";
        $_SESSION['lab_question_column'] = "lab_question";
        $_SESSION['difficulty_column'] = "difficulty_rating";
        $_SESSION['interest_column'] = "interest_rating";
    ?>
</head>
<body>
    <div class="login">
        <div class="login_left">
            <img src="img/gsu-logo.png" />
        </div>
        <div class="login_right">
            <h1>Login to RateMyLab</h1>
            <form id="input-form" action="login-to-grid.php" method="POST">
                <p>Enter Student ID</p>
                <input type="text" size="35" maxlength="30" name="student_id" id="student_id" required/>
                <p>Enter Student Password</p>
                <input type="password" size="35" maxlength="30" name="student_password" id="student_password" required />
                <br><br>
                <input type="button" id="student-button" value="Submit Student Info" />
                <p>Select Lab CRN</p>
                <select name="crn_dropdown" id="crn_dropdown" disabled></select>
                <p>Enter Instructor Password</p>
                <input type="password" size="35" maxlength="30" name="teacher_password" id="teacher_password" disabled />
                <br><br>
                <input type="button" id="class-button" value="Submit Class Info" disabled />
                <p>Select Lab Number</p>
                <select name="lab_dropdown" id="lab_dropdown" disabled></select>
                <br><br>
                <input type="submit" id="rate-button" value="Rate My Lab" disabled />
            </form>
        </div>
    </div>
</body>
</html>