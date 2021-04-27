<?php

if (!isset($_COOKIE['user_name'])) {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>This page was not found</h1>';
    echo '<h1>You do not have access. Please login</h1>';
    die();
}

include 'db_connection.php';

$part_name = $_POST['part_name'];
$part_desc = $_POST['part_desc'];
$b64_img = $_POST['base64_img'];
$car_id = $_POST['car_id'];

$sql = "SELECT Part_Name FROM PART WHERE Part_Name='$part_name'";
$result = mysqli_query($conn, $sql);
$exists = 0;
if (mysqli_num_rows($result) > 0) {
    $exists = 1; //this means that this part already exists
} 
if ($exists != 0) {
    $msg = "This part already exists. Did you mean to add another?";
    mysqli_close($conn);
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}
if ($exists == 0) {
    $sql = "INSERT INTO PART (Car_Id, Part_Name, Part_Description, Part_Img) VALUES (cast('$car_id' as int),'$part_name', '$part_desc','$b64_img')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("Location: /~abbarrer/final_proj/part_page.php?id=".$car_id);
}

?>
