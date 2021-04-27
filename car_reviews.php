
<?php

if (!isset($_COOKIE['user_name'])) {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>This page was not found</h1>';
    echo '<h1>You do not have access. Please login</h1>';
    die();
}

else {
    include 'db_connection.php';
    $car_id = $_GET["id"];
    $sql = "SELECT C_Rating_ID, C_Rating_Rating, C_Rating_Title, C_Rating_Comment FROM C_RATING WHERE Car_Id = cast('$car_id' as int)";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $fin_ech = '<table border="1" cellspacing="0" cellpadding="0" width="800" align="center"><tr><th>Rating_User</th><th>Rating</th><th>Title</th><th>Comment</th><tr>';
            while($row = mysqli_fetch_assoc($result)) {
                $fin_ech = $fin_ech."<tr><td>".$row['C_Rating_ID']."</td><td>".$row['C_Rating_Rating']."</td><td>".$row['C_Rating_Title']."</td><td>".$row['C_Rating_Comment']."</td></tr>";
            }
    } 
    else {
        echo "No results";
    }
    echo $fin_ech."</table>";
    }

?>
