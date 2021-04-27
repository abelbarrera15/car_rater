
<?php

    if (!isset($_COOKIE['user_name'])) {
        header("HTTP/1.0 404 Not Found");
        echo '<h1>This page was not found</h1>';
        echo '<h1>You do not have access. Please login</h1>';
        die();
    }
	
	include 'db_connection.php';

    $rating = $_POST['rating'];
    $title = $_POST['title'];
    $comment = $_POST['comment'];
    $brand_id = $_POST['brand_id'];
    $rating_id = $_POST['rating_id'];
    
	$sql = "SELECT B_Rating_Id, Brand_Id FROM B_RATING WHERE B_Rating_Id='$rating_id' AND Brand_Id=cast('$brand_id' as int)";
	$result = mysqli_query($conn, $sql);
    $exists = 0;
	if (mysqli_num_rows($result) > 0) {
        $exists = 1; //this means that this user has already reviewed
	} 
    if ($exists != 0) {
        $msg = "You've already rated this brand! Please rate another";
        mysqli_close($conn);
        echo '<script type="text/javascript">alert("' . $msg . '")</script>';
    }
    if ($exists == 0) {
        $sql = "INSERT INTO B_RATING (B_Rating_Id, Brand_Id, B_Rating_Rating, B_Rating_Title, B_Rating_Comment) VALUES ('$rating_id', cast('$brand_id' as int),cast('$rating' as int),'$title','$comment')";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: /~abbarrer/final_proj/brand_page.php");
    }

?>
