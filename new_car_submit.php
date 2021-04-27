<?php

if (!isset($_COOKIE['user_name'])) {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>This page was not found</h1>';
    echo '<h1>You do not have access. Please login</h1>';
    die();
}

include 'db_connection.php';

$car_name = $_POST['car_name'];
$car_desc = $_POST['car_desc'];
$b64_img = $_POST['base64_img'];
$brand_id = $_POST['brand_id'];

$sql = "SELECT CAR_Name FROM CAR WHERE CAR_Name='$car_name'";
$result = mysqli_query($conn, $sql);
$exists = 0;
if (mysqli_num_rows($result) > 0) {
    $exists = 1; //this means that this car already exists
} 
if ($exists != 0) {
    $msg = "This car already exists. Did you mean to add another?";
    mysqli_close($conn);
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}
if ($exists == 0) {
    $sql = "INSERT INTO CAR (Brand_Id, Car_Name, Car_Description, Car_Img) VALUES (cast('$brand_id' as int),'$car_name', '$car_desc','$b64_img')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("Location: /~abbarrer/final_proj/car_page.php?id=".$brand_id);
}

?>
