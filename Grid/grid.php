<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="grid-style.css">
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
    ?>
</head>

<body>
    <div class="container">
        <div id="dom-table">
            <?php
                echo "<h1>Question " . $_SESSION['current_question'] . "<br>Click on the graph at the point that best describes your opinion of today's lab</h1>";
            ?>
            <p id='Interesting'>Interesting</p>
            <p id='Easy'>Easy</p>
            <p id='Hard'>Hard</p>
            <p id='Boring'>Boring</p>
        </div>
    </div>

    <!-- Click to submit rating -->
    <form id="output_form" method="POST" action="submit-rating.php">
        <input type="submit" id="submit-button" value="Submit Rating" disabled></input>
        <!-- Hidden values for javascript to pass rating -->
        <input type="hidden" name="x_value" id="x_value" value=""></input>
        <input type="hidden" name="y_value" id="y_value" value=""></input>
    </form>

    <!-- Grid -->
    <script src="grid-script.js"></script>
</body>
</html>
