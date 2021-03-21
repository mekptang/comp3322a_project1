<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>buywelcome</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body style="margin-top: 60px">
<?php
    if(!isset($_SESSION['username'])){
        echo "<h1 class='redirrt'>You have not logged in</h1>";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=index.html\"/>";
    }else{

        echo '<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="main.php">UB Cinema</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li class="active"><a href="buywelcome.php">Buy A Ticket</a></li>
        <li><a href="comment.php">Movie Review<span class="sr-only">(current)</span></a></li>
        <li><a href="history.php">Purchase History</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>';

        $conn=mysqli_connect('sophia.cs.hku.hk', 'h3532746', 'kp7947', 'h3532746') or die ('Error! '.mysqli_connect_error($conn));

        $query = "select * from Film";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));

        if(mysqli_num_rows($result) > 0){
            echo "<div class='container'>";
            while($row = mysqli_fetch_array($result)){
                $filmId = $row['FilmId'];
                $query_b = "select * from BroadCast where FilmId='$filmId'";
                $result_b = mysqli_query($conn, $query_b) or die ('Failed to query '.mysqli_error($conn));

                echo "<div class='box'>";
                echo "<div class='h1f'><h1>".$row['FilmName']."</h1></div>";

                echo "<div class='pic'>";
                echo "<div id=\"poster_".$row['FilmId']."\"></div>";
                echo "</div>";

                echo "<div class='details'>";
                echo "<h3>Synopsis (Description): ".$row['Description']."</h3>";
                echo "<h4>Director: ".$row['Director']."</h4>";
                echo "<h4>Duration: ".$row['Duration']."</h4>";
                echo "<h4>Category: ".$row['Category']."</h4>";
                echo "<h4>Language: ".$row['Language']."</h4>";
                echo "<form method=\"get\" action=\"seatplantry.php\">";
                echo "<select class='form-control' name=\"broadcast\">";
                while($row_b = mysqli_fetch_array($result_b)){
                    echo "<option value=".$row_b['BroadCastId'].">".$row_b['Dates']." "
                    .$row_b['Time']." (".$row_b['day'].") "."House ".$row_b['HouseId']."</option>";
                }
                echo "</select>";
                
                echo '<br><div class="submittButtonWrapper redir"><button style="margin-left:5px" class="btn btn-sm btn-primary" type="submit">Submit</button></div>';
                echo "</form>";
                echo "</div>";
                echo "</div>";

                echo "<hr>";
            }
            echo "</div>";
        }
        mysqli_free_result($result);
        mysqli_free_result($result_b);
        mysqli_close($conn);
    }
?>

<script>
    $("#poster_1").prepend('<img class="poster" src="movie001.jpg">');
    $("#poster_2").prepend('<img class="poster" src="movie002.jpg">');
    $("#poster_3").prepend('<img class="poster" src="P3.png">');
    $("#poster_4").prepend('<img class="poster" src="movie004.jpg">');
</script>
</body>
</html>