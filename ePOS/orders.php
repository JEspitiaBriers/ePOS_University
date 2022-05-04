<?php
    require "head.php";

    if (isset($_SESSION['loggedin'])) {
        
        $getOrdersQuery = "SELECT orderID FROM orders";
        $getOrdersExe = mysqli_query($connection, $getOrdersQuery);
        $getOrdersResult = mysqli_num_rows($getOrdersExe);
        if($getOrdersResult == 0) {
            echo "Error getting orders.";
        }

        echo <<<HEREDOC
                <body>
                    <div id="body" class="limiter">
                        <div class="mainContainer">
                            <div class="wrap-mainContainer">
                            <div id="picContainer" class="container">
                                <img src="images/logoweb.png" id="logoweb">
                            </div>
                            <div class="workingArea">
                            <div class="container border border-dark">
                                <h6 id = "hClock"></h6>
                            </div>
                            <table>
                                <tr>
                                    <th>OrderID</th>
                                    <th>Products</th>
                                    <th>Payment Status</th>
                                    <th>Date/Time of Order</th>
                                    <th>Select Order</th>
                                </tr>
                                <tr>
                                    <td>New Order</td>
                                    <td>New Order</td>
                                    <td>New Order</td>
                                    <td>New Order</td>
                                    <td>
                                        <form action="index.php" method="GET">
                                        <input type="text" name="orderID" value="0" hidden readonly></input>
                                        <button style="background-color: #808080" type="submit">Create New Order</button>
                                        </form>
                                    </td>
                                </tr>
        HEREDOC;

        for($i = 0; $i < $getOrdersResult; $i++){
            while ($row = mysqli_fetch_assoc($getOrdersExe)){
            $prodString = "";
            $details = json_decode(file_get_contents("ordersFolder/order{$row['orderID'][$i]}.json"), true);
                echo "<tr>";
                echo "<td>{$row['orderID']}";
                echo "<td>";
                for($j = 0; $j < count($details['Products Selected']['Item']); $j++){
                    $prodString .= "{$details['Products Selected']['Qty'][$j]}" . "x " . "{$details['Products Selected']['Item'][$j]}" . " ";
                }
                if(strlen($prodString) > 35){
                    echo substr($prodString, 0, 32) . "...";
                }
                else {
                    echo $prodString;
                }
                echo "</td>";
                echo "<td>{$details['Payment Status']}</td>";
                echo "<td>{$details['Order Placed']}</td>";
                echo <<<HEREDOC
                                    <td>
                                        <form action="index.php" method="GET">
                                        <input type="text" name="orderID" value="{$row['orderID']}" hidden readonly></input>
                                        <button style="background-color: #808080" type="submit">Select Order {$row['orderID']}</button>
                                        </form>
                                    </td>
                HEREDOC;
                echo "</tr>";
            }
        }
        echo <<<HEREDOC
                            <div id="bottomMemu" class="container">
                                <footer class="row">
                                    <p id="footerText">
                                        ePOS v0.1
                                    </p>
                                </footer>
                            </div>
                        </div>
                    </div>
                </body
        HEREDOC; 
    }
    

    else{
        header("Refresh:0; url=login.php");
        
    }

    require "footer.php";
?>