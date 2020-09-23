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
	<h1>RateMyLab Login</h1>
	<form action="login-attempt.php" method="POST">
		<table>
			<tr>
				<td>Student</td>
				<td><select name="student_id">
				<?php
						# connect to mysql
						$conn = new mysqli($server, $username, $password, $database);
						if($conn->connect_error){
							die("Connection Failed");
						}
						# pull info from table
						$result = $conn->query("SELECT name, id FROM students");
						# create menu
						if($result->num_rows > 0){
							while($row = $result->fetch_assoc()){
								// teacher id = 0, don't want in student menu
								if($row["id"] != 0){
									echo "<option value=\"" . $row["id"] . "\">" . $row["name"] . "</option>";
								}
							}
						}
						$conn->close();
				?>
				</select></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" size="35" maxlength="30" name="password"></td>
			</tr>
		</table>
		<input type="submit" value="Login">
	</form>
</body>
</html>