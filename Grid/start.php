<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="grid-style.css">
    <title>RateMyLab</title>
</head>

<body>
    <?php
        # this can all probably be handled by the login mechanism
        # but until the database is up and running, this should suffice for question navigation purposes
        session_start();
        # how many questions are in this lab
        # need to pull this from database
        $_SESSION['num_questions'] = 3;
        $_SESSION['current_question'] = 0;
        header("Location: grid.php");
        exit;
    ?>
</body>
</html>