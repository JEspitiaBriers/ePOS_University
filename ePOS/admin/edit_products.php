<?php
require_once 'credentials.php';

// -- will just run a function to grab whatever product the admin just
// --edited and update the db (once passing validation )
// -- as of 19/04 no testing has been done on whether this works with the manage products table.
$productID = "";
$productName= "";
$productImg = "";
$productPrice = "";
$productDesc = "";
$noSoldProduct = "";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if($_SESSION['username'] == "admin"){
    if (isset($_POST['post'])){

            
        // Attempt to connect. Return an error if not.
        if (!$connection)
        {
            die("Connection failed: " . $mysqli_connect_error);
        }
        $productID= $_POST['productID'];
        $productName = $_POST['productName'];
        $productImg = $_POST['productImage'];
        $productPrice = $_POST['productPrice'];
        $productDesc = $_POST['productDesc'];
        $noSoldProduct = $_POST['noSold'];

    
    
    
    
        $query = "UPDATE posts SET title = '$title', created = '$created',content = '$content' WHERE postid = '$pid'";

        $result = mysqli_query($connection,$query);
    
        if ($result)
        {
            echo "Post edited.";
            header('Location: manage_posts.php');
        }
        else
        {    
            // show an unsuccessful signup message:
            $message = "Update failed, please try again<br>";
        }
        mysqli_close($connection);
    
    }else{
        echo "No user data was received. Go back to try again.";
        header('Location: manage_posts.php');
    }

}

?>