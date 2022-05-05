<?php
send();

function send(){
        require_once "head.php";
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
    if($orderContents['Payment Status'] == "AWAITING"){
        $_SESSION['openOrder'] .= 1;
    }
    else {
        for($i=0; $i<count($orderContents['Products Selected']['Qty']); $i++){
            for($j=0; $j<count($stockContents['Product']); $j++){
                if($orderContents['Products Selected']['Item'][$i] == $stockContents['Product'][$j]){
                    echo "<br><br>Stock for item {$stockContents['Product'][$j]}: {$stockContents['Stock'][$j]}<br>";
                    echo "Number sold {$orderContents['Products Selected']['Qty'][$i]}<br>";
                    $diffInCount[$j] = $stockContents['Stock'][$j] - $orderContents['Products Selected']['Qty'][$i];
                    echo "New stock for item {$stockContents['Product'][$j]}: {$diffInCount[$j]}";
                }
            }
        }
    }

    $_SESSION['sendingData'] = true;

    echo "</div>";
}

header("Refresh: 0, url='endOfDay.php'");
?>

a b c d => d a c b

a 