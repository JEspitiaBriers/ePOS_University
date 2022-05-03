<?php
require '../head.php';
require '../database/credentials.php';


$totalBalance= 2000.00;
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
echo <<<_END
        <div class = "fluid-container">
            <table class = "styled-CSS" cellpadding='2' cellspacing ='2'>
                <thead>
                    <tr>
                        <th>Sales Made (Count of Transactions passed)</th>
                        <th>Best Selling Product? </th>
                        <th>Total Products Sold (Total amount of all sold in a day)</th>
                        <th>Each item sold in a day? NEed to keep track of this somehow</th>
                        <th>Amount of Stock left(and how much sold?)</th>


                        

                        <th>Balance before earnings</th>
                        <th>Earnings</th>
                        <th>Loss</th>


                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
    _END;

    
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

$ptDQuery ="SELECT COUNT(payment_type) AS card FROM orders WHERE payment_type = 'CARD'; ";
$ptHQuery .="SELECT COUNT(payment_type) AS cash FROM orders WHERE payment_type = 'CASH'; ";



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
require '../footer.php';
?>