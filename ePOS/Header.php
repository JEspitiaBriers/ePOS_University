<?php
require_once "credentials.php";
session_start();

echo <<<END
    <h1>ePOS prototype v0.00200 (setup)</h1>
END;

session_destroy();