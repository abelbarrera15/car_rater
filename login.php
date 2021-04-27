<?php
	
	include 'db_connection.php';
	$username = $_POST['UserName'];
	$password = $_POST['Password'];


	$sql = "SELECT username, password FROM USER WHERE username='$username' and password='$password'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		setcookie("user_name",$username,time()+3600);
		header("Location: /~abbarrer/final_proj/brand_page.php");
		mysqli_close($conn);
	}
	else {
		$msg = "Wrong username and/or password -- or perhaps you need to register! Try again";
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
		mysqli_close($conn);
		header('Location: /~abbarrer/final_proj/index.html');
	}



?>
