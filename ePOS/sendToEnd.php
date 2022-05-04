<?php
require_once "head.php";
echo "<div style='position:absolute; left:205px;'>";

$checkQuery = "SELECT products FROM orders WHERE orderID = {$_SESSION['orderID']}";
$checkOrder = mysqli_query($connection, $checkQuery);
$orderResults = mysqli_num_rows($checkOrder);
if($orderResults == 0) {
    echo "Error getting order file for order {$_SESSION['orderID']} (send to end).";
}
$orderFile = mysqli_fetch_assoc($checkOrder)['products'];
$orderContents = json_decode(file_get_contents("ordersFolder/{$orderFile}"), true);
print_r($orderContents);

echo "<br><br>";

$recentStockQuery = "SELECT MAX(dayStart) as 'Recent Stock' FROM startOfDay";
$recentStockExe = mysqli_query($connection, $recentStockQuery);
$recentStockResult = mysqli_fetch_assoc($recentStockExe);

$stockQuery = "SELECT stock FROM startOfDay WHERE stock = 'stock{$recentStockResult['Recent Stock']}.json'";
$stockExe = mysqli_query($connection, $stockQuery);
$stockResults = mysqli_num_rows($stockExe);
if($stockResults == 0) {
    echo "Error getting stock file for stock {$recentStockResult['Recent Stock']} (send to end).";
}


$stockFile = mysqli_fetch_assoc($stockExe)['stock'];
$stockContents = json_decode(file_get_contents("stockFiles/{$stockFile}"), true);
print_r($stockContents);

subtract order contents from stock if the order is paid

echo "</div>";

//header("Location: endOfDay.php");

?>