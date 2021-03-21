<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>history</title>
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
      <li><a href="buywelcome.php">Buy A Ticket</a></li>
        <li><a href="comment.php">Movie Review<span class="sr-only">(current)</span></a></li>
        <li class="active"><a href="history.php">Purchase History</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>';
        echo'<div class="center">';
        echo "<h1>Purchase History</h1>";
        echo "<h3>Username: ".$username."</h3>";
        $conn=mysqli_connect('sophia.cs.hku.hk', 'h3532746', 'kp7947', 'h3532746') or die ('Error! '.mysqli_connect_error($conn));
        $query = "select * from Ticket inner join BroadCast using (BroadCastId) inner join Film using (FilmId) where UserId='$username'";
        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        $tog = 0;
        
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)) {
                if($tog%2==0){
                    echo '<div id="tog1">';
                }else{
                    echo '<div id="tog2">';
                }
                echo "TicketId: ".$row['TicketId']." $".$row['TicketFee']."(".$row['TicketType'].")"."<br>";
                echo "House: ".$row['HouseId']."<br>";
                echo "Seat: ".$row['SeatNo']."<br>";
                echo "FilmName: ".$row['FilmName']."(".$row['Category'].")"." ".$row['Duration']."<br>";
                echo "Language: ".$row['Language']."<br>";
                echo "Date: ".$row['Dates']."(".$row['day'].")"." ".$row['Time']."<br>";
                echo "<br>";
                echo '<div>';
                $tog++;
        }
    }
    echo'<div>';
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>
</body>
</html>