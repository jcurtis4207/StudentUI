<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Student Login</title>
	<style>
		body{line-height: 30px;}
    </style>
    <?php
		$server = "localhost:3308";
		$username = "jcurtis6";
		$password = "jcurtis6";
		$database = "students";
	?>
</head>
<body>
    <?php
        session_start();
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            # pull data from html form
            $input_id = $_POST["student_id"];
            $input_pass = $_POST["password"];
            $_SESSION['student_id'] = $input_id;
            # connect to mysql
            $conn = new mysqli($server, $username, $password, $database);
            if($conn->connect_error){
                    die("Connection Failed");
            }
            # pull data from database
            $result = $conn->query("SELECT name, password FROM students WHERE id=" . $input_id);
            if($result->num_rows > 0){
                $entry = $result->fetch_assoc();
                # if database password is blank, redirect to new login page
                if($entry["password"] == ""){
                    header("Location: new-login.html");
                    exit;
                }
                # compare entered password and database password
                if($input_pass != $entry["password"]){
                    echo "Login Failed";
                }else{
                    echo "Login Successful";
                }
            }
            $conn->close();
        }
    ?>
</body>
</html>