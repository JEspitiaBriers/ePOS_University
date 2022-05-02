<?php

require_once "head.php";
$_SESSION['orderID'] = '5';
$numOfProd = 0;
$prodSelectArray = Array();
$prodSelect = Array();

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
        $_SESSION['orderID'] = $newID['MAX(orderID)'];
    }
    else
    {
        die("Error inserting row: order (update_order.php) -> " . mysqli_error($connection));
    }
}

if($_SESSION['payment'] == 'CASH' && $_SESSION['cashGiven'] < $_SESSION['total']){
    echo "Enter change given or ensure enough cash has been received.<br><br>";
    header("Refresh:2; url=index.php");
}
else if($_SESSION['payment'] == 'CASH' && !$_SESSION['changeGiven']){
    Header("Location: http://localhost/ePOS_University/ePOS/cashAndChange.php");
}
else {
    if(count($_SESSION['quantity']) == 1){
        $numOfProd = $_SESSION['quantity'][0];
        $prodSelectArray = Array ("Qty" => $_SESSION['quantity'], "Item" => $_SESSION['itemTitle'], "Price" => $_SESSION['itemPrice']);
    }
    else {
        for($i=0; $i < count($_SESSION['quantity']); $i++){
            $numOfProd += $_SESSION['quantity'][$i];
            $prodSelectArray = array_merge($prodSelectArray, $prodSelect);
            $prodSelect = Array ("Qty" => $_SESSION['quantity'], "Item" => $_SESSION['itemTitle'], "Price" => $_SESSION['itemPrice']);
        }    
    }

    if($_SESSION['payment'] == 'CASH'){
        $purchase = Array (
            "Order Number" => $_SESSION['orderID'],
            "Number of Products" => $numOfProd,
            "Products Selected" => $prodSelectArray,
            "Total Cost" => $_SESSION['total'],
            "Payment Type" => $_SESSION['payment'],
            "Cash Given" => $_SESSION['cashGiven'],
            "Change Returned" => $_SESSION['change'],
            "Payment Status" => "NO DATA TO BE FOUND"
        );
    }
    else {
        $purchase = Array (
            "Order Number" => $_SESSION['orderID'],
            "Number of Products" => $numOfProd,
            "Products Selected" => $prodSelectArray,
            "Total Cost" => $_SESSION['total'],
            "Payment Type" => $_SESSION['payment'],
            "Payment Status" => "NO DATA TO BE FOUND"
        );
    }

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
        echo "Error Updating Order {$_SESSION['orderID']}";
    }
    else {
        echo "Order {$_SESSION['orderID']} has successfully been updated!";
    }
    echo <<<END
    <form action="createReceipt.php">   
        <input type="submit" value="Print Receipt">
    </form>
    END;
}
?>