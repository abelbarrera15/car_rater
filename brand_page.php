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
    <!-- Cookie Lib v1.4.1 -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.1/js.cookie.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <main></main>
    <div class="header">
      <h1> What car brand do you want to review or know more about? </h1>
      </br>
      </br>
      </br>
      </br>
    </div>
    <div class="brand_info" id = "brand_info"> 

    </div>

<?php
	
	include 'db_connection.php';

  // add the check if the token is here if not 404 part to the beginning of every code file here

  session_start() ;

  if (!isset($_COOKIE['user_name'])) {
    header("HTTP/1.0 404 Not Found");
    echo '<h1>This page was not found</h1>';
    echo '<h1>You do not have access. Please login</h1>';
    die();
  }

	$sql = "SELECT Brand_Id, Brand_Name, Brand_Description, Brand_Img FROM BRAND";
	$result = mysqli_query($conn, $sql);
    $brandArray = array();
	if (mysqli_num_rows($result) > 0) {
		while($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $brandArray[] = $row;
    }
        $_SESSION['brand_data'] = json_encode($brandArray);
        mysqli_close($conn);
	}
	else {
		$msg = "Something's gone wrong! Please try again";
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
		mysqli_close($conn);
    header("Location: /~abbarrer/final_proj/index.html");
	}
?>

<script>
      function main() {
        let brandData = <?php echo $_SESSION['brand_data'];?>;
        var brandHTML = document.getElementById("brand_info");
        let row_nums = brandData.length / 3
        if (parseInt(brandData.length / 3) != row_nums){
          row_nums = parseInt(brandData.length / 3) + 1
        }
        temp_html = ""
        for (let i = 1; i <= row_nums; i++) {
          temp_html = temp_html + "<div class='row'>"
          brandData.slice(((i*3) - 3),(i*3)).forEach( function (data) {
              temp_html = temp_html + "<div class='col-md-4'>"
              temp_html = temp_html + "<img style='width:150px;height:150px;' src=data:image/png;base64," + data.Brand_Img + "></img>"
              temp_html = temp_html + "</br></br>"
              temp_var = "location.href='https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/brand_review.html?id=" + data.Brand_Id + "'"
              temp_html = temp_html + "<button onclick=" + temp_var + " type='button'>Review</button>"
              temp_html = temp_html + "</br></br>"
              temp_var = "location.href='https://in-info-web4.informatics.iupui.edu/~abbarrer/final_proj/brand_reviews.php?id=" + data.Brand_Id + "'"
              temp_html = temp_html + "<button onclick=" + temp_var + " type='button'>See Reviews</button>"
              temp_html = temp_html + "</div>"
            }
          )
          temp_html = temp_html + "</div>"
          brandHTML.innerHTML = ""
          brandHTML.innerHTML += temp_html
        }
      }

      //need to add top right button on "header" div to "add" brand which redirects to a form which lets you add brand

      main();
</script>

</body>
</html>
