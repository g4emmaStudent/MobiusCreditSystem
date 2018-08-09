<html>

	<head>
		<title>Information Gathered</title>
	</head>

	<body>

	<?php
	
	echo "<p>Data processed</p>";

	$email = $_POST['email'];
	$password = $_POST['password'];




	$conn = new mysqli("localhost", "root", "");
	if($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "CREATE DATABASE IF NOT EXISTS mydb";
	if($conn->query($sql) === TRUE) {
		echo "Database created successfully";
	} else {
		echo "Error creating database: " . $conn->error;
	}
	$conn->close();




	$link = mysqli_connect("localhost", "root", "", "mydb");
	if($link === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	$sql = "CREATE TABLE IF NOT EXISTS UserList(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
		email VARCHAR(70) NOT NULL UNIQUE,
		password VARCHAR(30) NOT NULL,
		num_credits INT NOT NULL
	)";
	if(mysqli_query($link, $sql)){
	    echo "Table created successfully";
	} else{
	    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
	}
	mysqli_close($link);




	$conn = mysqli_connect("localhost", "root", "", "mydb");
	if(!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	$sql = "INSERT INTO UserList (email, password)
	VALUES ('$email', '$password')";
	if($conn->query($sql)===TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	mysqli_close($conn);


/*
	// $hash is what you would store in your database
	$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

	// $hash would be the $hash (above) stored in your database for this user
	$checked = password_verify($password, $hash);
	if ($checked) {
	    echo 'password correct</br>';
	} else {
	    echo 'wrong credentials</br>';
	}
*/

	echo "email: " . $email . "</br>";
	echo "password: " . $password . "</br>";

	?>

	</body>

</html>