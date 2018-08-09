<?php include('include/server.php'); ?>

<?php

session_start();

if(isset($_POST['reg_user'])) {

	$email = $_POST['email'];
	$password = $_POST['password_1'];

	if(($email==NULL)||($password==NULL)){
		echo "Please complete required fields.";
	} else if(!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
		echo "You have entered an invalid email address.";
	} else if(!ctype_alnum($password)) {
		echo "Wrong email/password!";	
	} else {

		$sql = "SELECT * FROM userlist WHERE email='$email' AND password='$password' ";

		$results = mysqli_query($db, $sql);

		$row = mysqli_fetch_assoc($results);

		if(mysqli_num_rows($results)==1) {
			$_SESSION['email'] = $email;
			$_SESSION['num_credits'] = $row['num_credits'];
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		} else {
			echo "Wrong email/password!";
		}

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
			<h2>Log In</h2>
		</div>

		<form method="post" action="login.php">

			<div class="input-group">
				<label>Email</label>
				<input type="text" name="email">
			</div>

			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password_1">
			</div>

			<div class="input-group">
				<button type="submit" class="btn" name="reg_user">Log In</button>
			</div>

			<p>
				Not a member yet? <a href="register.php">Register</a>
			</p>

		</form>
	</body>

</html>
