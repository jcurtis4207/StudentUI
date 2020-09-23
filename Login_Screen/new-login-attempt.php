<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>New Login</title>
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
            $teacher_password = $_POST["teacher_password"];
            $new_password = $_POST["new_password"];
            $confirm_password = $_POST["confirm_password"];
            $student_id = $_SESSION["student_id"];
            # check if new & confirm match
            if($new_password != $confirm_password){
                echo "Passwords Do No Match";
                exit;
            }
            # connect to mysql
            $conn = new mysqli($server, $username, $password, $database);
            if($conn->connect_error){
                    die("Connection Failed");
            }
            # pull teacher password from database
            $result = $conn->query("SELECT password FROM students WHERE id=0");
            if($result->num_rows > 0){
                $entry = $result->fetch_assoc();
                # compare entered teacher password and database password
                if($teacher_password != $entry["password"]){
                    echo "Teacher Password Incorrect";
                }else{
                    # update database entry with new password
                    $update = "UPDATE students SET password='$new_password' WHERE id='$student_id'";
                    if($conn->query($update) === TRUE){
                        echo "Successfully created password for id=" . $student_id;
                    }else{
                        echo "Error creating password for id=" . $student_id;
                    }
                }
            }
            $conn->close();
        }
    ?>
</body>
</html>