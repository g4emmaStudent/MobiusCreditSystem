<?php include('include/server.php'); ?>

<?php

session_start();

	if(isset($_POST['reg_user'])) {

		$email = $_POST['email'];
		$password = $_POST['password_1'];
		$confirm_password = $_POST['password_2'];

		$sql = "SELECT * FROM userlist WHERE email='$email'";
		$results = mysqli_query($db, $sql);

		if($password !== $confirm_password) {
			echo "Passwords don't match. Please try again.";
		} else if(($email==NULL)||($password==NULL)) {
			echo "Please complete required fields.";
		} else if(!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
			echo "Please enter a valid email address.";
		} else if(!ctype_alnum($password)) {
			echo "Only letters and numbers are allowed in your password.";
		} else if(strlen($password)<8) {
			echo "Your password must be at least 8 characters long.";
		} else if(mysqli_num_rows($results)>0) {
			echo "This email address already has an account registered. Please login using the link below.";
		} else {

			$sql = "INSERT INTO userlist (email, password, num_credits) VALUE ('$email','$password',100)";

			mysqli_query($db, $sql);

			$_SESSION['email'] = $email;
			$_SESSION['num_credits'] = 100;

			header('location: index.php');
		}
	}

?>


<!DOCTYPE html>

<html>
	<head>
		<title>Credit System</title>
	</head>

	<body>
		<div class="header">
			<h2>Register</h2>
		</div>

		<form method="post" action="register.php">

			<div class="input-group">
				<label>Email</label>
				<input type="text" name="email">
			</div>

			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password_1">
			</div>

			<div class="input-group">
				<label>Confirm Password</label>
				<input type="password" name="password_2">
			</div>

			<div class="input-group">
				<button type="submit" class="btn" name="reg_user">Register</button>
			</div>

			<p>
				Already a member? <a href="login.php">Log In</a>
			</p>

		</form>
	</body>

</html>
