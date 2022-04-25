<?php

$username = "";

if (isset($_POST['staff']))//checking if the value of user has been sent. this is the name of the button on the manage_users.php page
{
    require_once '../database/credentials.php';

    $username= $_POST['staff'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // Attempt to connect. Return an error if not.
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $query = "DELETE FROM staff WHERE username = '$username'";//query to delete user
    $result = mysqli_query($connection,$query);

    
    //test so that if it actually happened, nothing else done here
    if ($result)
    {
        // navigate back to the admin page:
        header('Location:admin_users.php');
    }
    else
    {    
        // show an unsuccessful signup message:
        $message = "Delete failed, please try again<br>";
    }
    
    echo $message;
    mysqli_close($connection);

}
else
{
    echo "No user data was received. Go back to try again.";
}



?>