<?php
require_once "head.php";
$_SESSION['changeGiven'] = false;
echo $_SESSION['changeGiven'];
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

header("Location: update_order.php");
?>