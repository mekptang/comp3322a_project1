<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>comment_submit</title>
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
        $conn=mysqli_connect('sophia.cs.hku.hk', 'h3532746', 'kp7947', 'h3532746') or die ('Error! '.mysqli_connect_error($conn));

        $comment = $_POST['cm'];
        $flimId =  $_POST['cmfilm'];
        $userId = $_SESSION['username'];
        $comment = strip_tags($comment);
        $query = "insert into Comment (FilmId, UserId, Comment) values ('$flimId', '$userId', '$comment')";

        if(!mysqli_query($conn, $query)){
            die ('Failed to query '.mysqli_error($conn));
        }

        mysqli_close($conn);
        echo "<h1 class='redirrt'>Your comment has been submitted.</h1>";
        echo "<meta http-equiv=\"refresh\" content=\"3;url=comment.php\"/>";
    }

?>
</body>