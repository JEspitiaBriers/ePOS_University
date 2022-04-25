<?php
require_once '../database/credentials.php';


$username ="";
$firstname = "";
$lastname = "";
$job_role = "";
$password = "";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (isset($_POST['staff'])){

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $username =$_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $job_role = $_POST['job_role'];
    $password = $_POST['password'];

    $query = "UPDATE staff SET firstname = '$firstname', lastname ='$lastname', job_role ='$job_role', password = '$password' WHERE username = '$username' ";

    $result = mysqli_query($connection, $query);

    if($result){
        header('Location: admin_users.php');
    }else{
        $message = "Update failed, please try again<br>";
    }
}else{
    echo "No user data was received. Go back to try again.";
    header('Location: admin_users.php');
}




/*
later to be added when header stuff is sorted.
if($_SESSION['username'] == "admin"){
    
}
*/


?>