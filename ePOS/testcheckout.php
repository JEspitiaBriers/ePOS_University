<?php

require_once "head.php";

$_SESSION['orderID'] = '2';
echo "Test Check Out. <br> orderID is {$_SESSION['orderID']}";

echo <<<END
<form action="update_order.php">   
    <input type="submit" value="Checkout">
</form>
END;
?>