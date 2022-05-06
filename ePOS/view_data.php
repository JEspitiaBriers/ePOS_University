<?php
require 'head.php';
require 'database/credentials.php';
//read the array
//increment counters
//add variables 
//read

$totalBalance= 2000.00;
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$testArray = array();
//$date = date();
//var = 

//$totalProductsArray[] = unserialize($_POST['$serializedstockChanges']);


echo <<<_END
        <div class = "fluid-container">
            <table class = "styled-CSS" cellpadding='2' cellspacing ='2'>
                <thead>
                    <tr>
                        <th>Sales Made (Count of all quantity in array in general)</th>

                        <th>Total Products Sold(Total amount of items in array products wise)</th>

                        <th>Each item sold in a day?</th>


                        <th>Amount of Stock(Get total stock level, remove total products sold, new)</th>
                        <th>Amount of Stock Left</th>

                        <th>Earnings. Total price of everything added together</th>

                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
    _END;

    


 //getting the product name if its first element
    
echo <<<_END
        <table class = "table-2" cellpadding='2' cellspacing ='2'>
            <thead>
                <tr>
                    <th>Total Card Payments</th>
                    <th>Total Cash Payments</th>
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