<?php

if (!isset($_COOKIE['user_name'])) {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>This page was not found</h1>';
    echo '<h1>You do not have access. Please login</h1>';
    die();
}

include 'db_connection.php';

$brand_name = $_POST['brand_name'];
$brand_desc = $_POST['brand_desc'];
$b64_img = $_POST['base64_img'];

$sql = "SELECT Brand_Name FROM BRAND WHERE Brand_Name='$brand_name'";
$result = mysqli_query($conn, $sql);
$exists = 0;
if (mysqli_num_rows($result) > 0) {
    $exists = 1; //this means that this brand already exists
} 
if ($exists != 0) {
    $msg = "This brand already exists. Did you mean to add another?";
    mysqli_close($conn);
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}
if ($exists == 0) {
    $sql = "INSERT INTO BRAND (Brand_Name, Brand_Description, Brand_Img) VALUES ('$brand_name', '$brand_desc','$b64_img')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("Location: /~abbarrer/final_proj/brand_page.php");
}

?>
