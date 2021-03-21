<head>
    <meta charset="utf-8" />
    <title>create</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<?php
    session_start();
    $conn=mysqli_connect('sophia.cs.hku.hk', 'h3532746', 'password', 'h3532746') or die ('Error! '.mysqli_connect_error($conn));
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "select * from Login where UserId='$username'";

        $result = mysqli_query($conn, $query) or die ('Failed to query '.mysqli_error($conn));
        if (mysqli_num_rows($result) == 0){
            echo "<h1 class='redirrt' onload = \"setTimeout()\">Invalid login, please login again</h1>";
            echo "<meta http-equiv=\"refresh\" content=\"3;url=index.html\"/>";
        }else{
            while($row = mysqli_fetch_array($result)) {
                //echo "pw: ".$row['PW'];
                if($row['PW'] == $password){
                    $_SESSION['username'] = $username;
                    session_write_close();
                    //echo $_SESSION['username'];
                    header("Location: main.php");
                }else{
                    echo "<h1 class='redirrt' onload = \"setTimeout()\">Invalid login, please login again</h1>";
                   echo "<meta http-equiv=\"refresh\" content=\"3;url=index.html\"/>";
                }
            }
            
        }
        mysqli_free_result($result);
        mysqli_close($conn);
    }

    
?>
