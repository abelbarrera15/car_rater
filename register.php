
<?php
	
	include 'db_connection.php';

    $username = $_POST['UserName'];
    $password = $_POST['Password'];
    
	$sql = "SELECT UserName FROM USERS";
	$result = mysqli_query($conn, $sql);
    $exists = 0;
	if (mysqli_num_rows($result) > 0) {
        // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
            if ($row['UserName'] == $_POST['UserName']) {
                $exists = 1;
            }	    
        }
	} 
    if ($exists != 0) {
        $msg = "This user already exists. Please submit a new one";
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
        mysqli_close($conn);
        header('Location: /~abbarrer/final_proj/registration.html');
    }
    if ($exists == 0) {
        $msg = "Thank you for registering!";
        $sql = "INSERT INTO USER (UserName, Password) VALUES ('$username', '$password')";
        mysqli_query($conn, $sql);
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
        mysqli_close($conn);
        header("Location: /~abbarrer/final_proj/index.html");
    }

?>
