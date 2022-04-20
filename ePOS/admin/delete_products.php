<?php
//this is a utility page with no html for the user to see

if (isset($_POST['prod']))
{
    require_once '../database/credentials.php';

    $productID = $_POST['prod'];

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }

    $query = "DELETE FROM products WHERE productID = '$productID'";
    $result = mysqli_query($connection,$query);

    
    //test so that if it actually happened, nothing else done here
    if ($result)
    {
        // navigate back to the admin page:
        header('Location: admin_products.php');
    }
    else
    {    
        $message = "Delete failed, please try again<br>";
    }
    
    echo $message;
    mysqli_close($connection);

}
else
{
    echo "No data was received. Go back to try again.";
}

?>