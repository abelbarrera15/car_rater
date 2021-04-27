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
      <h1> What part do you want to review or know more about? </h1>
      </br>
      </br>
      <a href="https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/new_part.html" id = "new_part"> <h4>Add New Part</h4> </a>
      </br>
      </br>
    </div>
    <div class="part_info" id = "part_info"> 

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

    $car_id = $_GET["id"];
	$sql = "SELECT Part_Id, Car_Id, Part_Name, Part_Description, Part_Img FROM PART WHERE Car_Id = cast('$car_id' as int)";
	$result = mysqli_query($conn, $sql);
    $partArray = array();
	if (mysqli_num_rows($result) > 0) {
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $partArray[] = $row;
    }
        $_SESSION['part_data'] = json_encode($partArray);
        mysqli_close($conn);
	}
	else {
		$msg = "This car has no parts. Choose another car or add a part";
        mysqli_close($conn);
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
?>

<script>
      function main() {
        const urlParams = new URLSearchParams(window.location.search);
        const car_id = urlParams.get('id');
        let partData = <?php echo $_SESSION['part_data'];?>;
        var partHTML = document.getElementById("part_info");
        document.getElementById("new_part").href="https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/new_part.html?car_id=" + car_id
        let row_nums = partData.length / 3
        if (parseInt(partData.length / 3) != row_nums){
          row_nums = parseInt(partData.length / 3) + 1
        }
        temp_html = ""
        for (let i = 1; i <= row_nums; i++) {
          temp_html = temp_html + "<div class='row'>"
          partData.slice(((i*3) - 3),(i*3)).forEach( function (data) {
              temp_html = temp_html + "<div class='col-md-4'>"
              temp_html = temp_html + "<img style='width:150px;height:150px;' src=data:image/png;base64," + data.Part_Img + "></img>"
              temp_html = temp_html + "</br>" + data.Part_Name
              temp_html = temp_html + "</br></br>"
              temp_var = "location.href='https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/part_review.html?id=" + data.Part_Id + "&car_id=" + data.Car_Id + "'"
              temp_html = temp_html + "<button onclick=" + temp_var + " type='button'>Review</button>"
              temp_html = temp_html + "</br></br>"
              temp_var = "location.href='https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/part_reviews.php?id=" + data.Part_Id + "&car_id=" + data.Car_Id + "'"
              temp_html = temp_html + "<button onclick=" + temp_var + " type='button'>See Reviews</button>"
              temp_html = temp_html + "</div>"
            }
          )
          temp_html = temp_html + "</div> </br> </br>" 
          partHTML.innerHTML = ""
          partHTML.innerHTML += temp_html
        }
      }
      
      main();
</script>

</body>
</html>
