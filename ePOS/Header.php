<?php
session_start();
require_once "database/credentials.php";
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
echo <<<END
    <h1>ePOS prototype v0.001 (setup)</h1>
END;
