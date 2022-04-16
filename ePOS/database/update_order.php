<?php

require_once("credentials.php");
$message = "...";

$orderID = $_SESSION['orderID'];
//it should be incremented from the highest value if the order is new
//checks if the order already exists
$checkQuery = "SELECT * FROM orders WHERE orderID = $orderID";
$checkOrder = mysqli_query($connection, $checkQuery);
if(mysqli_num_rows($checkOrder) == 0) {
    //order does not exist so create new order
    $newOrder = "INSERT INTO orders (orderID) VALUES ('');";
    if (mysqli_query($connection, $newOrder))
    {
        $queryNewID = "SELECT MAX(orderID) FROM orders";
        $getNewID = mysqli_query($connection, $queryNewID);
        $newID = mysqli_fetch_assoc($getNewID);
        $_SESSION['orderID'] =  $newID;
        //header("Location: http://localhost/ePOS_University/ePOS/database/update_order.php");
    }
    else
    {
        die("Error inserting row: order (update_order.php) -> " . mysqli_error($connection));
    }
}

$purchase = Array (
    "Order number" => $orderID,
    //"Number of Products" => $number_of_products,
    "Products Selected" => Array(
        "coke" => "1.00",
        "coke" => "1.00",
        "water" => "1.25",
        "fanta" => "1.00"
    )
    //"Total Cost" => $total_cost,
    //"Payment Type" => $payment_type,
    //"Payment Status" => $payment_status
);

//creates a json file for the order
$order = json_encode($purchase);
$fileName = "order{$orderID}.json";
$orderFile = file_put_contents("order{$orderID}.json", $order);
$updateProducts = "UPDATE orders SET products = '".$fileName."' WHERE orderID = $orderID";
mysqli_query($connection, $updateProducts);
//if($message == "..."){
//    header("Location: http://localhost/ePOS_University/ePOS/checkoutComplete.php");
//}
?>