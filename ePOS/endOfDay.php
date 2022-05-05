<?php
require_once "head.php";

echo $_SESSION['sendingData'];

if($_SESSION['sendingData']){
    echo "receiving";
}
else {
    echo "loading";
}
?>