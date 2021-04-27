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
$part_id = $_POST['part_id'];
$rating_id = $_POST['rating_id'];
$car_id = $_POST['car_id'];
$sql = "SELECT P_Rating_Id, Part_Id FROM P_RATING WHERE P_Rating_Id='$rating_id' AND Part_Id=cast('$part_id' as int)";
$result = mysqli_query($conn, $sql);
$exists = 0;
if (mysqli_num_rows($result) > 0) {
    $exists = 1; //this means that this user has already reviewed
} 
if ($exists != 0) {
    $msg = "You've already rated this car! Please rate another";
    mysqli_close($conn);
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}
if ($exists == 0) {
    $sql = "INSERT INTO P_RATING (P_Rating_Id, Part_Id, P_Rating_Rating, P_Rating_Title, P_Rating_Comment) VALUES ('$rating_id', cast('$part_id' as int),cast('$rating' as int),'$title','$comment')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("Location: /~abbarrer/final_proj/part_page.php?id=".$car_id);
}

?>
