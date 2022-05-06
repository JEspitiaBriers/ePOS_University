<?php
require 'head.php';
require 'database/credentials.php';
//read the array
//increment counters
//add variables 
//read

echo "<div style='position:absolute; left:205px;'>";
print_r($_SESSION);
echo "<br><br>";
$totalBalance= 2000.00;
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$testArray = array();
//$date = date();
//var = 

//$totalProductsArray[] = unserialize($_POST['$serializedstockChanges']);

//------- Sales Made Start
//------- Sales Made End

//------- Total products sold Start
//------- Total products sold End

//------- Each item sold Start
//------- Each item sold End




//------- Earnings Start

//------- Earnings End



echo <<<END
    <div class = "fluid-container">
        <table class = "styled-CSS" cellpadding='2' cellspacing ='2'>
            <thead>
                <tr>
                    <th>Orders Today</th>
                    <th>Total Products Sold</th>
                    <th>Each item sold in a day?</th>
                    <th>Stock (start)</th>
                    <th>Stock (end)</th>

                    <th>Earnings. Total price of everything added together</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$_SESSION['ordersToday']}</td>
                    <td>
END;

echo <<<END
                    </td>
                    <td></td>
                    <td>
END;
//------- Stock (Start of day) Start
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
for($i=0;$i<count($stockContents['Stock']);$i++){
    print_r($stockContents['Product'][$i]);
    echo " = ";
    print_r($stockContents['Stock'][$i]);
    echo "<br>";
}
//------- Stock (Start of day) End
echo "</td>";
echo "<td>";
//------- Stock (remaining) Start
foreach($_SESSION['stockChanges'] as $key => $value){
        foreach($value as $stock => $number){
            print_r($stock);
            echo " = ";
            print_r($number);  
            echo "<br>"; 
        }
    }
//------- Stock (remaining) End
echo "</td>";
echo "<td>";
echo "</td>";
echo "<td>";
echo "</td>";
echo <<<END
                </tr>
            </tbody>
        </table>
    </div>
END;
// <th>Orders Completed</th>
// <th>Sales Made (Count of all quantity in array in general)</th>
// <th>Total Products Sold(Total amount of items in array products wise)</th>
// <th>Each item sold in a day?</th>
// <th>Amount of Stock(Get total stock level, remove total products sold, new)</th>
// <th>Amount of Stock Left</th>
// <th>Earnings. Total price of everything added together</th>



 //getting the product name if its first element
    
echo <<<_END
        <table class = "table-2" cellpadding='2' cellspacing ='2'>
            <thead>
                <tr>
                    <th>Total Card Payments</th>
                    <th>Total Cash Payments</th>
                    <th>Total Saved Orders</th>
                </tr>
            </thead>
            <tbody>


_END;

$orderAtStartQuery = "SELECT COUNT(orderID) FROM orders";
$orderAtStartExe = mysqli_query($connection, $orderAtStartQuery);
$orderAtStartResult = mysqli_fetch_assoc($orderAtStartExe);

//print_r($orderAtStartResult);

$ptDQuery ="SELECT COUNT(payment_type) AS card FROM orders WHERE payment_type = 'CARD'; ";
$ptHQuery ="SELECT COUNT(payment_type) AS cash FROM orders WHERE payment_type = 'CASH'; ";
$ptSQuery ="SELECT COUNT(payment_type) AS saved FROM orders WHERE payment_type = 'NULL'; ";



//maybe need date clause to = whatever today is?
//$ptHQuery .="SELECT COUNT(payment_type) AS cash FROM orders WHERE payment_type = 'CASH' AND trans_date = 'date.now'; ";

$result = mysqli_query($connection, $ptDQuery);
while($rows = mysqli_fetch_assoc($result)){
    echo "<tr>";
    echo "<td>{$rows['card']}</th>";

}
$result2 = mysqli_query($connection, $ptHQuery);
while($rows = mysqli_fetch_assoc($result2)){
    echo "<td>{$rows['cash']}</th>";
}
$result3 = mysqli_query($connection, $ptSQuery);
while($rows = mysqli_fetch_assoc($result3)){
    echo "<td>{$rows['saved']}</th>";
}

echo <<<_END
    </tbody>
</table>

_END;



//compare to last week /day 
//export to excel? 
//<th>Amount of open baskets (order lists never finished)</th>
/*
, product details (best selling product, how much each product sold,
 total stock after all the purchases), general p/l(total revenue gained in a day), then order details (total ca

*/
require 'footer.php';
?>