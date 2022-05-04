<?php
require_once "head.php";
$_SESSION['changeGiven'] = false;
echo "<div style='position:absolute; left:205px;'> {$_SESSION['changeGiven']}";
$_SESSION['quantity'] = $_GET['quantity'];
print_r($_SESSION['quantity']);
$_SESSION['cashGiven'] = $_GET['cashGiven'];
print_r($_SESSION['cashGiven']);
$_SESSION['itemTitle'] = $_GET['itemTitle'];
print_r($_SESSION['itemTitle']);
$_SESSION['itemPrice'] = $_GET['itemPrice'];
print_r($_SESSION['itemPrice']);
$_SESSION['payment'] = $_GET['payment'];
print_r($_SESSION['payment']);
$_SESSION['total'] = $_GET['total'];
print_r($_SESSION['total']);
if($_SESSION['payment'] == "SAVE"){   
    $_SESSION['payment_status'] = "AWAITING";
}
else {
    $_SESSION['payment_status'] = "RECIEVED";
}
echo "</div>";

header("Location: update_order.php");

$daiyAmountGained = 0;
$totalTransactions = 0;
$totalProductsSold = 0;
//need a proper way to store how much each one paid? probs store each product and quantity,
//read if the product alredy exists, if so add to the total of the amount that product has been bought
//maybe have this in update orders.php?
?>