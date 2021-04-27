<!DOCTYPE html>
<html lang="en">
  <meta charset="utf-8" />
  <style>
  .header {
    text-align: center;
  }

  .row{
    text-align:center;
    margin:0 auto;
  }

  .row .col-md-4{
    display:inline-block;
    vertical-align: middle;
    float: none;
    text-align: center;
  }

  </style>
  <head>
    <title>Car Rating Application</title>
    <!-- Latest compiled CSS v3.4.1 -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
    />
    <!-- jQuery library v3.5.1-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript v3.4.1 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Ajax library v3.5.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <main></main>
    <div class="header" id="header">
      <h1> What car do you want to review or know more about? </h1>
      </br>
      </br>
      <a href="https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/new_car.html"> <h4>Add New Car</h4> </a>
      </br>
      </br>
    </div>
    <div class="car_info" id = "car_info"> 

    </div>

<?php
	
	include 'db_connection.php';

  if (!isset($_COOKIE['user_name'])) {
    header("HTTP/1.0 404 Not Found");
    echo '<script type="text/javascript">var temp = document.getElementById("header"); temp.innerHTML = ""; </script>';
    echo '<h1>This page was not found</h1>';
    echo '<h1>You do not have access. Please login</h1>';
    die();
  }

    $brand_id = $_GET["id"];
	$sql = "SELECT Car_Id, Brand_Id, Car_Name, Car_Description, Car_img FROM CAR WHERE Brand_Id = cast('$brand_id' as int)";
	$result = mysqli_query($conn, $sql);
    $carArray = array();
	if (mysqli_num_rows($result) > 0) {
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $carArray[] = $row;
    }
        $_SESSION['car_data'] = json_encode($carArray);
        mysqli_close($conn);
	}
	else {
		$msg = "This brand has no cars. Choose another brand or add a car";
        mysqli_close($conn);
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
?>

<script>
      function main() {
        let carData = <?php echo $_SESSION['car_data'];?>;
        var carHTML = document.getElementById("car_info");
        let row_nums = carData.length / 3
        if (parseInt(carData.length / 3) != row_nums){
          row_nums = parseInt(carData.length / 3) + 1
        }
        temp_html = ""
        for (let i = 1; i <= row_nums; i++) {
          temp_html = temp_html + "<div class='row'>"
          carData.slice(((i*3) - 3),(i*3)).forEach( function (data) {
              temp_html = temp_html + "<div class='col-md-4'>"
              temp_var = "javascript:window.location='https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/part_page.php?id=" + data.Car_Id + "';"
              temp_html = temp_html + "<img style='width:150px;height:150px;' src=data:image/png;base64," + data.Car_img + " onclick=" + temp_var + "></img>"
              temp_html = temp_html + "</br>" + data.Car_Name
              temp_html = temp_html + "</br></br>"
              temp_var = "location.href='https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/car_review.html?id=" + data.Car_Id + "&brand_id=" + data.Brand_Id + "'"
              temp_html = temp_html + "<button onclick=" + temp_var + " type='button'>Review</button>"
              temp_html = temp_html + "</br></br>"
              temp_var = "location.href='https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/car_reviews.php?id=" + data.Car_Id + "&brand_id=" + data.Brand_Id + "'"
              temp_html = temp_html + "<button onclick=" + temp_var + " type='button'>See Reviews</button>"
              temp_html = temp_html + "</div>"
            }
          )
          temp_html = temp_html + "</div> </br> </br>" 
          carHTML.innerHTML = ""
          carHTML.innerHTML += temp_html
        }
      }
      
      main();
</script>

</body>
</html>
