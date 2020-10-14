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
        if($_SESSION['current_question'] > $_SESSION['num_questions']){
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

    <!-- Values passed from javascript grid -->
    <div id="x_value">0</div>
    <div id="y_value">0</div>

    <!-- Click a button to submit rating or skip the question -->
    <form>
        <input type="button" id="send" value="Submit Rating" onclick="submitRating();" disabled></input>
        <input type="button" id="skip" value="Skip Question" onclick="skipRating();"></input>
    </form>

    <script>
        // instead of js alerts, will be php posts to db
        function submitRating(){
            // if question is rated
            if(document.getElementById("x_value").innerHTML != 0 && document.getElementById("y_value").innerHTML != 0){
                alert("Submitting: " + document.getElementById("x_value").innerHTML + ", " + document.getElementById("y_value").innerHTML);
                window.open("grid.php", "_self");
            }
            // if question is not rated
            else{
                alert("Please Rate Question Before Submitting");
            }
        }
        function skipRating(){
            alert("Submitting: 0,0");
            window.open("grid.php", "_self");
        }
    </script>

    <!-- Grid -->
    <script src="grid-script.js"></script>
</body>
</html>
