<?php
$_SESSION['orderID'] = '0';

echo <<<END
<form action="http://localhost/ePOS_University/ePOS/database/update_order.php">   
    <input type="submit" value="Checkout">
</form>
END;
?>