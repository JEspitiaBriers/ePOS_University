<?php
require_once "head.php";

if(isset($_SESSION['orderID'])){
    echo "Create Receipt <br> the current orderID is " . $_SESSION['orderID'] . "<br><br>";
}
else{
    echo "create receipt <br> session orderID not set";
}

$checkQuery = "SELECT * FROM orders WHERE orderID = {$_SESSION['orderID']}";
$checkOrder = mysqli_query($connection, $checkQuery);
$orderResults = mysqli_num_rows($checkOrder);
if($orderResults == 0) {
    echo "Error getting order file for order {$_SESSION['orderID']} (receipt).";
}

$purchaseDetails = mysqli_fetch_assoc($checkOrder);

$orderContents = file_get_contents("ordersFolder/{$purchaseDetails['products']}");
$contentsArray = json_decode($orderContents, true);
$selected = $contentsArray["Products Selected"];

/*change due*/
if($purchaseDetails['payment_type'] == "CARD"){
    $change = 0;
}
else {
    $amountPaid  = rand(0, 5) + $purchaseDetails['total_cost'];//to be entered during checkout screen
    $change = $amountPaid - $purchaseDetails['total_cost'];
}

$serverName = "Self-Service";
$dateOfPurchase = "01/01/01";
$timeOfPurchase = "01:01:01";
echo <<<END
    <div class="receiptCenter">
        <img src="images/logoweb.png" id="logoweb">
        <p>ePOS Group Sales Medium <br>
        All Saints Campus, Metropolitan University, <br>
        Manchester M15 6BH <br> <br>
        Store: C0.17, TEL: 0161 123 1234 <br>
        Order: {$_SESSION['orderID']} Number of Items: {$purchaseDetails['number_of_products']}<br>
        -------------------------------------------<br>
        <table>
        <tr>
            <th>Qty</th>
            <th>Item</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
END;
foreach ($selected as $Qty=>$item){
    echo "<tr>";
    $priceQuery = "SELECT price FROM products WHERE productID = 1"; //WHERE product_name = {stroupper($item)}
    $priceCheck = mysqli_query($connection, $priceQuery);
    $priceResult = mysqli_fetch_assoc($priceCheck);
    $price = floatval($priceResult['price']);
    $Qty = floatval($Qty);
    $priceQty = $price * $Qty;
    echo "<td>{$Qty}</td>";
    echo "<td>{$item}</td>";
    echo "<td>{$priceResult['price']}</td>";
    echo "<td>{$priceQty}</td>";
    echo "</tr>";
}
echo <<<END
    </table>
    Total Cost: £{$purchaseDetails['total_cost']}<br>
END;
if($purchaseDetails['payment_type'] == "CASH"){
        echo "
        {$purchaseDetails['payment_type']}: £{$amountPaid}<br>
        Change Due: £{$change}<br>";
}
else {
        echo "{$purchaseDetails['payment_type']}: £{$purchaseDetails['total_cost']}<br>";
}
echo <<<END
        -------------------------------------------<br>
        Server: {$serverName} Date: {$dateOfPurchase} Time: {$timeOfPurchase}
        </p>
    </div>
END;



?>