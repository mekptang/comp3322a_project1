<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>seatplantry</title>
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
        if(isset($_GET['broadcast'])){
            $conn=mysqli_connect('sophia.cs.hku.hk', 'h3532746', 'kp7947', 'h3532746') or die ('Error! '.mysqli_connect_error($conn));
            $broadcastid = $_GET['broadcast'];
            $query = "select * from Film inner join  BroadCast on Film.FilmId=BroadCast.FilmId where BroadCast.BroadCastId='$broadcastid'";
            $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            echo "<div class='con'>";
            echo "<div class='bx'>";
            echo "<div class='formWrapper_seatplantry'>";
            echo "<h1>Ticketing</h1>";
            echo "<table id=\"ticketinfo\">";
            echo "<tr><td>Cinema:</td>"."<td>"."UB"."</td></tr>";
            echo "<tr><td>House:</td>"."<td>House ".$row['HouseId']."</td></tr>";
            echo "<tr><td>Film:</td>"."<td>".$row['FilmName']."</td></tr>";
            echo "<tr><td>Category:</td>"."<td>".$row['Category']."</td></tr>";
            echo "<tr><td>Show Time:</td>"."<td>".$row['Dates']." (".$row['day'].") ".$row['Time']."</td></tr>";
            echo "</table>";

            $house = $row['HouseId'];
            $query = "select * from House where HouseId='$house'";
            $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
            $row = mysqli_fetch_array($result);
            $hrow = $row['HouseRow'];
            $hcol = $row['HouseCol'];

            echo "<form method=\"get\" action=\"buyticket.php\">";
            echo "<table id=\"seatinfo\">";
            for ($x = $hrow; 0 < $x; $x--) {
                $ch = chr(64+$x);
                echo"<tr>";
                for ($y = 1; $y <= $hcol; $y++){
                    $query_v = "select * from Ticket where BroadCastId='$broadcastid' and SeatNo='".$ch.$y."' and Valid=0";
                    $result_v = mysqli_query($conn, $query_v) or die ('Failed to query '.mysqli_error($conn));
                    $row_v = mysqli_fetch_row($result_v);
                    if($row_v == 0){
                        echo"<td class='seat'>";
                        echo "<input type=\"checkbox\" name=\"seatnum[]\" value=".$ch.$y.">";
                        echo "<span class='seatWrapper'><span class='seatNo'>".$ch.$y."</span></span>";
                    }else{
                        echo"<td class='seat sold'>";
                        echo "<input type=\"checkbox\" name=\"seatnum[]\" value=".$ch.$y." disabled>";
                        echo "<span class='seatWrapper'><span class='seatNo'>".$ch.$y."<br><span class='soldText'>Sold</span></span></span>";
                    }
                    echo"</td>";
                }
                echo"</tr>";
            }
            echo "<tr><td id='screen' colspan=".$hcol.">SCREEN</td></tr>";
            echo "</table>";
            echo "<input type='hidden' name='broadcast' value='$broadcastid'><br>";
            echo "<div class='submittButtonWrapper'><input id='submit_sp' class='btn btn-primary' type='submit' value='Submit'></div><br>";
            echo "<div class='submittButtonWrapper'><input id='submit_sp' class='btn btn-primary' type='button' value='Cancel' onclick=location.href='buywelcome.php'></div>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            mysqli_free_result($result);
            mysqli_close($conn);
        }
    }
    
?>

    <script>
        $(document).ready(function(){
            $('.seat').click(function(e){
                if(!$(this).closest('td').hasClass('sold')){
                    $(this).closest('td').toggleClass('seat-border');
                    if($(this).closest('td').find('input').attr('checked')){
                        $(this).closest('td').find('input').removeAttr('checked');
                    }else{
                        $(this).closest('td').find('input').attr('checked', true);
                    }
                }
            });
        });
    </script>
</body>
</html>