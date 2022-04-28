<?php
require '../head.php';
require '../database/credentials.php';

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
echo <<<_END
        <div class = "fluid-container">
            <table class = "styled-CSS" cellpadding='2' cellspacing ='2'>
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Number Sold</th>
                </tr>
            </thead>
            <tbody>
_END;



?>