<?php
require_once '../database/credentials.php';

// -- will just run a function to grab whatever product the admin just
// --edited and update the db (once passing validation )
// -- as of 19/04 no testing has been done on whether this works with the manage products table.
$productID = "";
$productName= "";
$productImg = "";
$productPrice = "";
$productDesc = "";
$noSoldProduct = "";


//number of prod sold wil need to increase everytime an item is sold
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (isset($_POST['prod'])){

            
    // Attempt to connect. Return an error if not.
    if (!$connection)
    {
        die("Connection failed: " . $mysqli_connect_error);
    }
    $productID= $_POST['productID'];
    $productName = $_POST['product_name'];
    $productImg = $_POST['product_image'];
    $productPrice = $_POST['price'];
    $productDesc = $_POST['product_description'];
    $noSoldProduct = $_POST['number_sold'];





    $query = "UPDATE products SET product_name = '$productName', price = '$productPrice',product_description = '$productDesc', product_image = '$productImg', number_sold = '$noSoldProduct' WHERE productID = '$productID'";

    $result = mysqli_query($connection,$query);

    if ($result)
    {
        header('Location: admin_products.php');
    }
    else
    {    
        // show an unsuccessful signup message:
        $message = "Update failed, please try again<br>";
    }
    mysqli_close($connection);

}else{
    echo "No user data was received. Go back to try again.";
    header('Location: admin_products.php');
}

/*

if($_SESSION['username'] == "admin"){
    
}
*/

?>