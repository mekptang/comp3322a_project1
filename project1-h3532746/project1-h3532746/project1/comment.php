<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>comment</title>
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
      <li><a href="buywelcome.php">Buy A Ticket</a></li>
        <li class="active"><a href="comment.php">Movie Review<span class="sr-only">(current)</span></a></li>
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
        echo'<div class="center">';
        echo '<form id="cmform" action="comment_submit.php" method="post">';
        echo '<span>Film Name: </span><select class="form-control" id="fname" name="cmfilm">';
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                $filmId = $row['FilmId'];
                $filmName = $row['FilmName'];
                echo "<option value='$filmId'>".$filmName."</option>";
            }
        }
        echo '</select>';
        echo '<br><br>';
        echo '<div class="submittButtonWrapper">';
        echo '<textarea placeholder="Please input comment here" class="center" rows="20" cols="80" name="cm" required></textarea>';
        echo'</div>';

        
        echo '</form>';
        echo '<br>';
        echo '<div class="submittButtonWrapper">';
        echo '<button type="button" style="margin-right:8px" class="btn btn-sm btn-primary" onclick="cmview()">View comment</button>';
        echo '<button class="btn btn-sm btn-primary" type="submit" form="cmform">Submit comment</button>';
        echo '</div>';
        echo "<div id=\"cmrecord\"> </div>";
        echo'</div>';
        mysqli_free_result($result);
        mysqli_close($conn);
    }
?>

<script>
    function cmview(){
        var xmlhttp;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var mesgs = document.getElementById("cmrecord");
                    mesgs.innerHTML = xmlhttp.responseText;
                }
            }
        var fid = document.getElementById("fname");
        var fidval = document.getElementById("fname").value;
        var fname = document.getElementById("fname");
        var fnametext = fname.options[fname.selectedIndex].text;

		xmlhttp.open("GET", "comment_retrieve.php?fname="+fnametext+"&fid="+fidval, true);
        
        console.log("comment_retrieve.php?fname="+fnametext+"&fid="+fidval);
		xmlhttp.send();
    }
</script>
</body>
</html>