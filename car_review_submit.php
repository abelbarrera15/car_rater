
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
$car_id = $_POST['car_id'];
$rating_id = $_POST['rating_id'];
$brand_id = $_POST['brand_id'];
$sql = "SELECT C_Rating_Id, Car_Id FROM C_RATING WHERE C_Rating_Id='$rating_id' AND Car_Id=cast('$car_id' as int)";
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
    $sql = "INSERT INTO C_RATING (C_Rating_Id, Car_Id, C_Rating_Rating, C_Rating_Title, C_Rating_Comment) VALUES ('$rating_id', cast('$car_id' as int),cast('$rating' as int),'$title','$comment')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    //echo($brand_id);
    header("Location: /~abbarrer/final_proj/car_page.php?id=".$brand_id);
}

?>
