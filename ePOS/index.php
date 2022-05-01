<?php
    include "head.php";


    //DJ general notes 20/04
    //

  


    $productsQuery = "SELECT * FROM products";
    $resultProductsQuery = mysqli_query($connection, $productsQuery);
    $nProducts = mysqli_num_rows($resultProductsQuery);
    $ean13=0;


    if (isset($_SESSION['loggedin'])) {

        echo <<<HEREDOC
            
                <form action="update_order.php">   
                <input type="submit" value="Checkout">
                </form>
                <a href="logout.php">Logout</a>
            

                <body>
                <div class="checkoutButton position-absolute top-50 start-0">
                    <button class="btn btn-info btn-warning" type="button">Orders</button><br>
                    <button class="btn btn-info btn-warning" type="button">End of day process</button>
                </div>
                

                <div id="body" class="limiter">
                    <div class="mainContainer">
                        <div class="wrap-mainContainer">
                    <div id="picContainer" class="container">
                        <img src="images/logoweb.png" id="logoweb">
                    </div>
                    <div class="workingArea">
                    <div id="time" class="container border border-dark">
                        Time + Date
                    </div>
                    <div id="itemsContainer" class="container border-start border-end border-dark">
                        <div class="row">
                            <div id="itemsSelection" class="col-9 border-dark">
                                <nav class="col ">
                                    <div class="row">
                                        <div class="col">Option1</div>
                                        <div class="col">Option2</div>
                                        <div class="col">Option3</div>
                                        <div class="col">Option4</div>
                                    </div>
                                </nav>
                                <div class="searchbar">
                                    <input type="text" id="myInput" autofocus="autofocus" onkeyup="searchbar()" placeholder="Search for names.." title="Type in a name">
                                </div>
                                <div id="listOfItems" class="p-4">
        HEREDOC;

        if ($nProducts > 0){

            for ($i=0; $i<$nProducts; $i++) 
            {


                while ($row = mysqli_fetch_assoc($resultProductsQuery)){
                    $productID = $row['productID'];
                    $productName = $row['product_name'];
                    $price = $row['price'];
                    $product_description = $row['product_description'];
                    $number_sold = $row['number_sold'];
                    $pic_url = $row['product_image'];
                    $ean13 = $row['EAN13'];

                

                echo <<<HEREDOC
                <div class="item">
                    <div>
                        <img class="img"src="$pic_url">
                        <div class="itemName">$productName</div>
                        <div class="itemDetails">
                            <span hidden class="itemPrice">$price</span>
                            <span hidden class="EAN13">$ean13</span>
                            <span hidden class="pid">$productID</span>
                        </div>
                    </div>
                </div>

                HEREDOC;

                }

            }
        }

        else{
            echo "No products yet";
        }

        echo <<<HEREDOC
                                    

                                </div> 
                            </div>
                            <div id="checkout" class="col border-start border-dark">
                                <form action="test.php" method="GET">
                                    <div class="cart-items">
                                    </div>
                                    <div class="cart-total">
                                        <strong class="cart-total-title">Total</strong>
                                        <span class="cart-total-price">£0</span>
                                    </div>
                                    <div class="checkoutButton">
                                        <button class="btn btn-warning btn-lg btn-block" type="submit">Checkout</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        <div id="bottomMemu" class="container">
                            <div class="row border border-dark border-bottom">
                                <div class="col"></div>
                                <div class="col">Option 1</div>
                                <div class="col">Option 2</div>
                                <div class="col">Option 3</div>
                                <div class="col">Option 4</div>
                                <div class="col"></div>
                            </div>
                            <footer class="row">
                                <p id="footerText">
                                    ePOS v0.1
                                </p>
                            
                            </footer>
                        </div>
                    </div>
        HEREDOC; 
    }
    

    else{
        header("Refresh:0; url=login.php");
        
    }

    require "footer.php";
?>