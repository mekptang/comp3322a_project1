<?php
session_start();
?>

<?php
if(!isset($_SESSION['username'])){
    echo "<h1 class='redirrt'>You have not logged in</h1>";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=index.html\"/>";
}else{
    $conn=mysqli_connect('sophia.cs.hku.hk', 'h3532746', 'kp7947', 'h3532746') or die ('Error! '.mysqli_connect_error($conn));
    $filmId = $_GET['fid'];
    $flimName = $_GET['fname'];
    
    $query = "select * from Comment where FilmId='$filmId'";
    $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)) {
            print "<h2>Viewer: ".$row['UserId']."</h2>";
            print "<h3>Comment: ".$row['Comment']."</h3>";
            print "<hr>";
        }
    }
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>

