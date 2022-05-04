<?php

require_once "head.php";
$numOfProd = 0;
$prodSelectArray = Array();
$prodSelect = Array();

echo "<div style='position:absolute; left:205px;'>";
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
    echo "Enter cash given and ensure enough cash has been received.<br><br>";
    header("Refresh:3; url=index.php");
}
else if($_SESSION['payment'] == 'CASH' && !$_SESSION['changeGiven']){
    Header("Location: cashAndChange.php");
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
            "Payment Status" => $_SESSION['payment_status'],
            "Order Placed" => date("d/m/y H:i:s")
        );
    }
    else {
        $purchase = Array (
            "Order Number" => $_SESSION['orderID'],
            "Number of Products" => $numOfProd,
            "Products Selected" => $prodSelectArray,
            "Total Cost" => $_SESSION['total'],
            "Payment Type" => $_SESSION['payment'],
            "Payment Status" => $_SESSION['payment_status'],
            "Order Placed" => date("d/m/y H:i:s")
        );
    }

    //creates a json file for the order
    $order = json_encode($purchase);
    $fileName = "order{$_SESSION['orderID']}.json";
    $orderFile = file_put_contents("ordersFolder/order{$_SESSION['orderID']}.json", $order);

    //creating random data to fill the fields of a new order
    //data is only random for testing purposes.
    //Data will be inputed during item selection
    $updateProducts = "UPDATE orders SET number_of_products = {$numOfProd}, products = '".$fileName."', total_cost = {$_SESSION['total']} WHERE orderID = {$_SESSION['orderID']}";
    $updated = mysqli_query($connection, $updateProducts);
    if(!$updated){
        echo "Error Updating Order {$_SESSION['orderID']}";
    }
    else {
        echo "Order {$_SESSION['orderID']} has successfully been updated!";
        
    }
    if($_SESSION['payment'] == 'SAVE'){
        echo <<<END
            <form action="orders.php">   
                <input type="submit" value="Return to Orders">
            </form>
        </div>
        END;
    }
    else {
        echo <<<END
        <form action="createReceipt.php">   
            <input type="submit" value="Print Receipt">
        </form>
    </div>
    END;
    }
}
?>