<?php
// default values for Xampp:
// specifies the MySQL login details along with some about the database to use
$dbhost  = 'localhost';
$dbuser  = 'root';
$dbpass  = '';
$dbname  = 'ePOS';


//establish connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//display error message if failed to connect
if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}

?>