<?php
$db = mysqli_connect('localhost','root','');
if(!$db) die("Error connecting to MySQL database.");
mysqli_select_db($db, "mydb");


$conn = new mysqli("localhost", "root", "");
if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE DATABASE IF NOT EXISTS mydb";
if($conn->query($sql) === TRUE) {

} else {
	echo "Error creating database: " . $conn->error;
}
$conn->close();


$link = mysqli_connect("localhost", "root", "", "mydb");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS userlist(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(70) NOT NULL,
	password VARCHAR(30) NOT NULL,
	num_credits INT NOT NULL
)";
if(mysqli_query($link, $sql)){

} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
}

$sql = "CREATE TABLE IF NOT EXISTS transaction_history(
	transaction_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	from_id INT NOT NULL,
	to_id INT NOT NULL,
	num_credits INT NOT NULL
)";
if(mysqli_query($link, $sql)){

} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
}

mysqli_close($link);
?>