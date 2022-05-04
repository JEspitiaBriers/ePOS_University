<?php
require_once "head.php";

echo "<div style='position:absolute; left:205px;'>";
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


$stockQuery = "SELECT stock FROM startOfDay WHERE stock = 'stock{$recentStockResult['Recent Stock']}.json'";
$stockExe = mysqli_query($connection, $stockQuery);
$stockResults = mysqli_num_rows($stockExe);
if($stockResults == 0) {
    echo "Error getting stock file for stock {$recentStockResult['Recent Stock']} (send to end).";
}
$stockFile = mysqli_fetch_assoc($stockExe);
echo $stockFile;
$stockContents = json_decode(file_get_contents("stockFiles/{$stockFile}"), true);
print_r($stockContents);

//subtract order contents from stock if the order is paid

if($orderFile['Payment Status'] == "AWAITING"){
    
}
else {
    for($i=0; $i<count($orderContents['Products Selected']['Qty']); $i++){
        if($orderContents['Products Selected']['Item'][$i] == $stockContents['Product'][$i]){
            $diffInCount[$i] = $stockContents['Stock'][$i] - $orderContents['Products Selected']['Qty'][$i];
            $stockContents['Stock'][$i] -= $diffInCount[$i];
        }
    }
}

echo "</div>";

header("Location: endOfDay.php");
?>