<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="grid-style.css">
    <title>RateMyLab</title>
</head>

<body>
    <?php
        session_start();
        echo "All " . $_SESSION['total_questions'] . " Questions Rated";
        echo "<br>This is a placeholder to show that the question navigation works";
        session_unset();
        session_destroy();
    ?>
</body>
</html>