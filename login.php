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
        # database credentials
        $_SESSION['db_server'] = "localhost";
        $_SESSION['db_username'] = "root";
        $_SESSION['db_password'] = "Singapore47";
        $_SESSION['db_database'] = "RateMyLab_new";
        # database variables
        $_SESSION['students_table'] = "student";
        $_SESSION['student_id_column'] = "Stu_id";
        $_SESSION['student_crn_column'] = "lab_crn1";
        $_SESSION['student_password_column'] = "Stu_passwd";
        $_SESSION['original_password_column'] = "orig_password";
        $_SESSION['student_fname_column'] = "first_name";
        $_SESSION['student_lname_column'] = "last_name";
        $_SESSION['teachers_table'] = "PROFESSOR";
        $_SESSION['teacher_id_column'] = "prof_id";
        $_SESSION['semester_column'] = "Semester";
        $_SESSION['year_column'] = "year_1";
        $_SESSION['labs_table'] = "LAB";
        $_SESSION['lab_crn_column'] = "Lab_Crn";
        $_SESSION['lab_teacher_id_column'] = "professor_id";
        $_SESSION['teacher_password_column'] = "Instructor_pass";
        $_SESSION['assignments_table'] = "assignment";
        $_SESSION['assignment_crn_column'] = "lab_crn2";
        $_SESSION['assignment_number_column'] = "Assignment_no";
        $_SESSION['total_questions_column'] = "Total_no_Questions";
        $_SESSION['ratings_table'] = "rating";
        $_SESSION['rating_crn_column'] = "lab_crn3";
        $_SESSION['rating_student_id_column'] = "Student_id";
        $_SESSION['rating_assignment_number_column'] = "Assignment_no2";
        $_SESSION['lab_question_column'] = "Question_no";
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