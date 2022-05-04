<?php
require_once "head.php";

echo $_SESSION['orderID'];
$checkQuery = "SELECT products FROM orders WHERE orderID = {$_SESSION['orderID']}";
$checkOrder = mysqli_query($connection, $checkQuery);
$orderResults = mysqli_num_rows($checkOrder);
if($orderResults == 0) {
    echo "Error getting order file for order {$_SESSION['orderID']} (send to end).";
}

$recentStockQuery = "SELECT MAX(dayStart) as 'Recent Stock' FROM startOfDay";
$recentStockExe = mysqli_query($connection, $recentStockQuery);
$recentStockResult = mysqli_fetch_assoc($recentStockExe);
print_r($recentStockResult['Recent Stock']);


$stockQuery = "SELECT stock FROM startOfDay WHERE stock = 
    stock{$recentStockResult['Recent Stock']}";
$stockExe = mysqli_query($connection, $stockQuery);
$stockResults = mysqli_num_rows($stockExe);
if($stockResults == 0) {
    echo "Error getting stock file for stock {$recentStockResult['Recent Stock']} (send to end).";
}
$stockFile = mysqli_fetch_assoc($stockExe)['stock'];
$stockContents = json_decode(file_get_contents("stockFiles/{$stockFile}"), true);
print_r($stockContents);
//header("Location: endOfDay.php");
?>