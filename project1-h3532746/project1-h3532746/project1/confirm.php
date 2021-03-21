<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>main</title>
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
        $username = $_SESSION['username'];
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

        if(isset($_GET['broadcast'])){

            $conn=mysqli_connect('sophia.cs.hku.hk', 'h3532746', 'kp7947', 'h3532746') or die ('Error! '.mysqli_connect_error($conn));
            $broadcastid = $_GET['broadcast'];
            $query = "select * from Film inner join  BroadCast on Film.FilmId=BroadCast.FilmId where BroadCast.BroadCastId='$broadcastid'";
            $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            echo "<div class='con'>";
            echo "<div class='bx'>";
            echo "<div class='formWrapper_seatplantry'>";
            echo "<h1>Order information</h1>";
            $checkdup = 0;
            $query_store = array();
            $item = $_GET['item'];
            $sum = 0;
            for($x = 0; $x < $item*2; $x=$x+2){
                $seatno = $_GET['price'][$x];
                $fee = $_GET['price'][$x+1];
                echo "<table id=\"ticketinfo\">";
                echo "<tr><td>Cinema:</td><td>"."UB"."</td></tr>";
                echo "<tr><td>House:</td><td>House ".$row['HouseId']."</td></tr>";
                echo "<tr><td>SeatNo:</td><td>".$seatno."</td></tr>";
                echo "<tr><td>Film:</td><td>".$row['FilmName']."</td></tr>";
                echo "<tr><td>Category:</td><td>".$row['Category']."</td></tr>";
                echo "<tr><td>Show Time:</td><td>".$row['Dates']." (".$row['day'].") ".$row['Time']."</td></tr>";
                echo "<tr><td>Ticket Fee:</td><td>".$fee."</td></tr>";
                echo "</table><br>";
                if($fee == 'Adult($75)'){
                    $type = 'Adult';
                    $fee = 75;
                }elseif($fee == 'Student/Senior($50)'){
                    $type = 'Student/Senior';
                    $fee = 50;
                }
                $sum = $sum + $fee;
                $query_v = "select * from Ticket where BroadCastId='$broadcastid' and SeatNo='".$seatno."' and Valid=0";
                $result_v = mysqli_query($conn, $query_v) or die ('Failed to query '.mysqli_error($conn));
                $row_v = mysqli_fetch_row($result_v);
                if($row_v > 0){
                    $checkdup++;
                }
                $query_store[] = "insert into Ticket (SeatNo, BroadCastId, Valid, UserId, TicketType, TicketFee)
                 values ('$seatno', '$broadcastid', '0', '$username', '$type', '$fee')";
            }
            
            if($checkdup == 0){
                foreach ($query_store as $value) {
                    if(!mysqli_query($conn, $value)){
                        die ('Failed to query '.mysqli_error($conn));
                    }
                }
            }

            echo "<span id='totalfee'>Total fee: $ ".$sum."</span>";
            echo "<hr>";
            echo "Please present valid proof of age/status when purchasing Student or Senior tickets before entering the cinema house.<br>";
            echo "<div class='submittButtonWrapper'><input id='submit_sp' class='btn btn-primary' type='button' value='OK' onclick=location.href='buywelcome.php'></div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        
    }
    mysqli_free_result($result);
    mysqli_free_result($result_v);
    mysqli_close($conn);
    
?>
</body>
<script>

</script>
</html>