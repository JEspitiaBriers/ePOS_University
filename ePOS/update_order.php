<?php

require_once "head.php";
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
        echo "<div style='position:absolute; left:205px;'> Error Updating Order {$_SESSION['orderID']} </div>";
    }
    else {
        echo "<div style='position:absolute; left:205px;'>Order {$_SESSION['orderID']} has successfully been updated!";
        
    }

    if($_SESSION['payment'] == 'SAVE'){
        echo <<<END
            <form action="orders.php">   
            <button class="btn btn-warning btn-lg btn-block" type="submit">Return to Orders</button>
            </form>
        </div>
        END;
    }
    else {
        $stockChanges = send($connection);
        $_SESSION['stockChanges'] = $stockChanges;
        $serializedstockChanges = serialize($stockChanges);
        //print_r($stockChanges);
        print_r($serializedstockChanges);
        echo <<<END
        <form action="createReceipt.php" method='POST'> 
            <button class="btn btn-warning btn-lg btn-block" type="submit">Print Receipt</button>
        </form>
    </div>
    END;
    }
}

function send($connection){
    echo "<div style='position:absolute; left:205px;'>";
    $checkQuery = "SELECT products FROM orders WHERE orderID = {$_SESSION['orderID']}";
    $checkOrder = mysqli_query($connection, $checkQuery);
    $orderResults = mysqli_num_rows($checkOrder);
    if($orderResults == 0) {
        echo "Error getting order file for order {$_SESSION['orderID']} (send to end).";
    }
    $orderFile = mysqli_fetch_assoc($checkOrder);
    $orderContents = json_decode(file_get_contents("ordersFolder/{$orderFile['products']}"), true);

    $recentStockQuery = "SELECT MAX(dayStart) as 'Recent Stock' FROM startOfDay";
    $recentStockExe = mysqli_query($connection, $recentStockQuery);
    $recentStockResult = mysqli_fetch_assoc($recentStockExe);


    $stockQuery = "SELECT stock FROM startOfDay WHERE stock = 'stock{$recentStockResult['Recent Stock']}.json'";
    $stockExe = mysqli_query($connection, $stockQuery);
    $stockResults = mysqli_num_rows($stockExe);
    if($stockResults == 0) {
        echo "Error getting stock file for stock {$recentStockResult['Recent Stock']} (send to end).";
    }
    $stockFile = mysqli_fetch_assoc($stockExe);
    $stockContents = json_decode(file_get_contents("stockFiles/{$stockFile['stock']}"), true);

    //subtract order contents from stock if the order is paid
    $diffPerProduct = array();
    for($i=0; $i<count($orderContents['Products Selected']['Qty']); $i++){
        for($j=0; $j<count($stockContents['Product']); $j++){
            if($orderContents['Products Selected']['Item'][$i] == $stockContents['Product'][$j]){
            
                $diffInCount = $stockContents['Stock'][$j] - $orderContents['Products Selected']['Qty'][$i];
                $perProcuct = Array ($stockContents['Product'][$j] => $diffInCount);
                array_push($diffPerProduct, $perProcuct);
            }
        }
    }
    echo "</div>";
    return $diffPerProduct;
}
?>