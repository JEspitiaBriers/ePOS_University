<?php

require_once "head.php";
$_SESSION['orderID'] = '5';
$numOfProd = 0;
$prodSelectArray = Array();
$prodSelect = Array();
if(isset($_SESSION['orderID'])){
    echo "Update Order <br> the current orderID is " . $_SESSION['orderID'] . "<br><br>";
    print_r($_GET['itemTitle']); 
    echo "<br>";
    print_r($_GET['itemPrice']);
    echo "<br>";
    print_r($_GET['pid']);
    echo "<br>";
    print_r($_GET['total']);
    echo "<br>";
    print_r($_GET['payment']);
    echo "<br>";
    print_r($_GET['quantity']);
    echo "<br><br>";
}
else{
    echo "update order <br> session orderID not set";
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

for($i=0; $i < count($_GET['quantity']); $i++){
    $numOfProd += $_GET['quantity'][$i];
    $prodSelectArray = array_merge($prodSelectArray, $prodSelect);
    $prodSelect = Array ("Qty" => $_GET['quantity'], "Item" => $_GET['itemTitle'], "Price" => $_GET['itemPrice']);
    echo $i;
    echo "<br>";
}

$purchase = Array (
    "Order Number" => $_SESSION['orderID'],
    "Number of Products" => $numOfProd,
    "Products Selected" => $prodSelectArray,
    "Total Cost" => $_GET['total'],
    "Payment Type" => $_GET['payment'],
    "Payment Status" => "NO DATA TO BE FOUND"
);

//creates a json file for the order
$order = json_encode($purchase);
$fileName = "order{$_SESSION['orderID']}.json";
$orderFile = file_put_contents("ordersFolder/order{$_SESSION['orderID']}.json", $order);

//creating random data to fill the fields of a new order
//data is only random for testing purposes.
//Data will be inputed during item selection
$updateProducts = "UPDATE orders SET products = '".$fileName."' WHERE orderID = {$_SESSION['orderID']}";
$updated = mysqli_query($connection, $updateProducts);
if(!$updated){
    echo "Error Updating";
}
echo <<<END
<form action="createReceipt.php">   
    <input type="submit" value="Print Receipt">
</form>
END;
?>