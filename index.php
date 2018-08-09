<?php include('include/server.php'); ?>

<?php 

	session_start();

	if(!isset($_SESSION['email'])) {
		header('location: login.php');

	}
	if(isset($_POST['send_credits'])) {


		if((int)$_POST['amount']<=0) {
			echo "Error: The number of credits you send must be a positive integer.";
		} else if(!(is_int(0 + $_POST['amount']))) {
			echo "Error: The number of credits you send must be a positive integer.";
		} else {
			$updated_num_credits = ($_SESSION['num_credits'] - $_POST['amount']);

			if($updated_num_credits<0) {
			echo "Error: Insufficient balance to complete transaction.";
			} else {

			$sql = "INSERT INTO transaction_history (from_id, to_id, num_credits) VALUE ('"
								.$_SESSION['id']."', '"
								.$_POST['id']."', '"
								.$_POST['amount']."' )";

			mysqli_query($db, $sql);

			$sql = "UPDATE userlist SET num_credits=" . $updated_num_credits . " WHERE id = " . $_SESSION['id'];
			mysqli_query($db, $sql);

			$sql = "SELECT num_credits FROM userlist WHERE id = " . $_POST['id'];
			$row = mysqli_fetch_array(mysqli_query($db, $sql));
			$id_credits = $row['num_credits'];

			$sql = "UPDATE userlist SET num_credits=" . ($id_credits + $_POST['amount']) . " WHERE id = " . $_POST['id'];
			mysqli_query($db, $sql); 

			$_SESSION['num_credits'] = $updated_num_credits;

			}
		}

	} if(isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION);
		header("location: login.php");
	}

	$sql = "SELECT * FROM userlist WHERE email='".$_SESSION['email']."' ";
	$results = mysqli_query($db, $sql);
	$row = mysqli_fetch_assoc($results);
	$_SESSION['id'] = $row['id'];


	$sql = "SELECT * FROM userlist WHERE email != '".$_SESSION['email']."'";

	$results = mysqli_query($db, $sql);

	/*
	$hash = password_hash("123", PASSWORD_DEFAULT, ['cost' => 12]);
	echo $hash;

	$checked = password_verify("456", $hash);
	if($checked) {
		echo 'password correct';
	} else {
		echo 'incorrect credentials';
	}
	*/

	?> 

<!DOCTYPE html>
<html>

	<head>
		<title>Credit System</title>
	</head>

	<body>

		<div class = "header">
			<h2><b>Homepage</b></h2>
		</div>

		<div class = "text">
			<h4><b>You are now logged in.</b></h4>
		</div>

		<div class = "display_creds">
			<p>Welcome <b><?php echo $_SESSION['email']; ?></b>, you currently have <b><?php echo $_SESSION['num_credits']; ?></b> credits.</p>
		</div>

	</body>

<html>

	<?php

	while($row = mysqli_fetch_assoc($results)) {
		?><b><?php echo $row['email'] . " "; ?> </b>currently has<b> <?php
		echo $row['num_credits']; ?> </b>credits.

		<form method="post" action="index.php">

			<div class="input-group">
				<input type="text" name="amount">
			</div>

			<div class="input-group">
				<button type="submit" class="btn" name="send_credits">Send</button>
			</div>

			<div>
				<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
			</div>

		</form>

		<br>

		<?php

	}

?>

<html>
	<body>
		<p> <a href="index.php?logout='1'" style="color: red;">Logout</a> </p>
	</body>
</html>


