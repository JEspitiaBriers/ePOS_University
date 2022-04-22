<?php

require_once "header.php";
$isNewOrder = false;
if(isset($_SESSION['orderID'])){
    echo "the current orderID is " . $_SESSION['orderID'] . "<br><br>";
}
else{
    echo "session orderID not set";
}
//it should be incremented from the highest value if the order is new
//checks if the order already exists
$checkQuery = "SELECT * FROM orders WHERE orderID = {$_SESSION['orderID']}";
$checkOrder = mysqli_query($connection, $checkQuery);
$orderResults = mysqli_num_rows($checkOrder);
if($orderResults == 0) {
    //order does not exist so create new order
    $newOrder = "INSERT INTO orders (orderID) VALUES ('');";
    if (mysqli_query($connection, $newOrder))
    {
        $isNewOrder = true;
        $queryNewID = "SELECT MAX(orderID) FROM orders";
        $getNewID = mysqli_query($connection, $queryNewID);
        $newID = mysqli_fetch_assoc($getNewID);
        echo $newID['MAX(orderID)'];
        $_SESSION['orderID'] = $newID['MAX(orderID)'];
    }
    else
    {
        die("Error inserting row: order (update_order.php) -> " . mysqli_error($connection));
    }
}

$purchase = Array (
    "Order number" => $_SESSION['orderID'],
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
$fileName = "order{$_SESSION['orderID']}.json";
$orderFile = file_put_contents("order{$_SESSION['orderID']}.json", $order);

//creating random data to fill the fields of a new order
//data is only random for testing purposes.
//Data will be inputed during item selection
if($isNewOrder == true) {
    $numOfPro = rand(1, 500);
    if($numOfPro % 3 <= 1.5){
        $payment_type = "CASH";
    }
    else {
        $payment_type = "CARD";
    }
    if($numOfPro % 6 >= 3) {
        $payment_status = "AWAITING";
    }
    else {
        $payment_status = "RECEIVED";
    }
    $updateProducts = "UPDATE orders SET number_of_products = '".$numOfPro."', products = '".$fileName."', total_cost = '". 1.20 * $numOfPro ."',
     payment_type = '".$payment_type."', payment_status = '".$payment_status."' WHERE orderID = {$_SESSION['orderID']}";
}
else {
    $updateProducts = "UPDATE orders SET products = '".$fileName."' WHERE orderID = {$_SESSION['orderID']}";
}
mysqli_query($connection, $updateProducts);
?>