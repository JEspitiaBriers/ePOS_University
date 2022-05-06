<?php
require_once "head.php";

print_r($_SESSION['stockChanges']);
$stockChanges = $_SESSION['stockChanges'];

echo gettype($stockChanges);
print_r($stockChanges);

$checkQuery = "SELECT products FROM orders WHERE orderID = {$_SESSION['orderID']}";
$checkOrder = mysqli_query($connection, $checkQuery);
$orderResults = mysqli_num_rows($checkOrder);
if($orderResults == 0) {
    echo "Error getting order file for order {$_SESSION['orderID']} (receipt).";
}

$purchaseDetails = mysqli_fetch_assoc($checkOrder)['products'];

$orderContents = json_decode(file_get_contents("ordersFolder/{$purchaseDetails}"), true);

$servedQuery = "SELECT firstname FROM staff WHERE username = '{$_SESSION['username']}'";
$servedExe = mysqli_query($connection, $servedQuery);
$servedResult = mysqli_fetch_assoc($servedExe);
$serverName = $servedResult['firstname'];
$dateOfPurchase = date('d/m/y');
$timeOfPurchase = date('H:i:s');
echo <<<END
    <div class="receiptCenter">
        <img src="images/logoweb.png" id="logoweb">
        <p>ePOS Group Sales Medium <br>
        All Saints Campus, Metropolitan University, <br>
        Manchester M15 6BH <br> <br>
        Store: C0.17, TEL: 0161 123 1234 <br>
        Order: {$_SESSION['orderID']} Number of Items: {$orderContents['Number of Products']}<br>
        -------------------------------------------<br>
        <table>
        <tr>
            <th>Qty</th>
            <th>Item</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
END;
for($i = 0; $i < count($orderContents['Products Selected']['Item']); $i++){
    $price = $orderContents['Products Selected']['Qty'][$i] * $orderContents['Products Selected']['Price'][$i];
    echo "<tr>";
    echo "<td>{$orderContents['Products Selected']['Qty'][$i]}</td>";
    echo "<td>{$orderContents['Products Selected']['Item'][$i]}</td>";
    echo "<td>£{$orderContents['Products Selected']['Price'][$i]}</td>";
    echo "<td>£{$price}</td>";
    echo "</tr>";
}
echo <<<END
    </table>
    Total Cost: £{$orderContents['Total Cost']}<br>
    {$orderContents['Payment Type']}: £{$orderContents['Total Cost']}<br>
END;
if($orderContents['Payment Type'] == "CASH"){
    echo "Cash Given: £{$orderContents['Cash Given']}<br>
        Change Returned: £{$orderContents['Change Returned']}<br>";
}
echo <<<END
        -------------------------------------------<br>
        Served By: {$serverName} Date: {$dateOfPurchase} Time: {$timeOfPurchase}
        </p>
    </div>
    <div style='position:absolute; left:205px;'>
        <form action="sendToEnd.php">
            <input type="submit" value="Return To Orders">
        </form>
    </div>
END;

?>