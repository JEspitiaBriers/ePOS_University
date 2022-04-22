<?php

require_once "header.php";

$_SESSION['orderID'] = '8';
echo "orderID is {$_SESSION['orderID']}";

echo <<<END
<form action="update_order.php">   
    <input type="submit" value="Checkout">
</form>
END;
?>