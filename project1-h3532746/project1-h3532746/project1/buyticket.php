<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>buyticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
<?php
    if(!isset($_SESSION['username'])){
        echo "<h1 class='redirrt'>You have not logged in</h1>";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=index.html\"/>";
    }else{
        if(isset($_GET['broadcast']) && isset($_GET['seatnum'])){
            $conn=mysqli_connect('sophia.cs.hku.hk', 'h3532746', 'kp7947', 'h3532746') or die ('Error! '.mysqli_connect_error($conn));
            $broadcastid = $_GET['broadcast'];
            $query = "select * from Film inner join  BroadCast on Film.FilmId=BroadCast.FilmId where BroadCast.BroadCastId='$broadcastid'";
            $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            echo "<div class='con'>";
            echo "<div class='bx'>";
            echo "<div class='formWrapper_seatplantry'>";
            echo "<h1>Cart</h1>";
            echo "<table id=\"ticketinfo\">";
            echo "<tr><td>Cinema:</td>"."<td>"."UB"."</td></tr>";
            echo "<tr><td>House:</td>"."<td>House ".$row['HouseId']."</td></tr>";
            echo "<tr><td>Film:</td>"."<td>".$row['FilmName']."</td></tr>";
            echo "<tr><td>Category:</td>"."<td>".$row['Category']."</td></tr>";
            echo "<tr><td>Show Time:</td>"."<td>".$row['Dates']." (".$row['day'].") ".$row['Time']."</td></tr>";
            echo "</table><br>";

            echo "<form method='get' action='confirm.php'>";
            $item = 0;
            foreach ($_GET['seatnum'] as $value) {
                $item++;
                echo $value.":";
                echo "<input type='hidden' name='price[]' value='$value'>";
                echo "<select class='form-control comment_button' name='price[]'>";
                echo "<option value='Adult($75)'>Adult($75)</option>";
                echo "<option value='Student/Senior($50)'>Student/Senior($50)</option>";
                echo "</select>";
                echo "<br>";
            }

            echo "<input type='hidden' name='item' value='$item'>";
            echo "<br><div class='submittButtonWrapper'><button id='submit_sp' type='submit' class='btn btn-primary' name='broadcast' value='$broadcastid'>Confirm</button></div>";
            //echo "<div class='submittButtonWrapper'><input id='submit_sp' class='btn btn-primary' type='submit' value='Submit'></div><br>";
            echo "</form>";
            //echo "<div class='submittButtonWrapper'><button id='submit_sp class='btn btn-primary' onclick=location.href='buywelcome.php'>Back</button></div>";
            echo "<br><div class='submittButtonWrapper'><input id='submit_sp' class='btn btn-primary' type='button' value='Back' onclick=location.href='buywelcome.php'></div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }else{
            echo "<h1 class='redirrt'>You have not choose any moive. Re-directing...</h1>";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=buywelcome.php\"/>";
        }
    }
?>
</body>
</html>