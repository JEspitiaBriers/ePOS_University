<?php
require '../head.php';
require '../database/credentials.php';

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
echo <<<_END
        <div class = "fluid-container">
            <table class = "styled-CSS" cellpadding='2' cellspacing ='2'>
            <thead>
                <tr>
                    <th>Sales Made (Count of Transactions passed)</th>
                    <th>Best Selling Product? </th>
                    <th>Balance before earnings</th>
                    <th>Earnings</th>
                    <th>Loss</th>
                    <th>Total Card / Cash Payments</th>
                    <th>Total Products Sold (Total amount of all sold in a day)</th>
                    <th>Amount of open baskets (order lists never finished)</th>
                    <th>Each item sold in a day? NEed to keep track of this somehow</th>
                    <th>Amount of Stock left(and how much sold?)</th>
                </tr>
            </thead>
            <tbody>
_END;
//compare to last week /day 
//export to excel? 

$query ='';


?>