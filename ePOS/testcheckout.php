<?php

session_start();

$_SESSION['orderID'] = '0';

echo <<<END
<form action="database/update_order.php">   
    <input type="submit" value="Checkout">
</form>
END;
?>