<?php
require_once "head.php";
$_SESSION['change'] = floatval($_SESSION['cashGiven']) - floatval($_SESSION['total']);
echo "£{$_SESSION['cashGiven']} - £{$_SESSION['total']} = £" . $_SESSION['change'] . ' change<br>';
$_SESSION['changeGiven'] = true;
echo <<<END
    <form action="update_order.php" method="GET">
    <button class="btn btn-warning btn-lg btn-block" type="submit">Next</button>
    </form>
END;
?>