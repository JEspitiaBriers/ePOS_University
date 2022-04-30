<?php
date_default_timezone_set('Europe/London');
require_once "database/credentials.php";
session_start();
//only one session start. 
//we do this in the header as it is one of the files CONSTANTLY being used by every other page, so it makes sense to start the session here
//and end session either after a logout or time out
//22/04 - DJ - onload display ct should change the H6 div id'd s clock, however it does not.


$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//display error message if failed to connect
if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}



echo <<<_END

    <!DOCTYPE html>
    <html>
    <head>
        <script src="js/clock.js"></script>
        <script src="js/main.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ePos</title>
        <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
        <link rel="stylesheet" href="css/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body onload = "display_ct">
        <nav class = "navbar"></nav>
    



_END;

//<a href="logout.php">Logout</a>
//changing the nav bar based off user access level
if(isset($_SESSION['loggedIn']) && $_SESSION['job_role'] == "Boss" ){

}else if  (isset($_SESSION['loggedIn'])){//will be the standard user, admin or user

}
?>