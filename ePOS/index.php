<?php
    require "head.php";


    //DJ general notes 20/04
    //

    if(!isset($_SESSION['orderID']) || empty($_SESSION['orderID'])){
        $_SESSION['orderID'] = 0;
    }
    else {
        $_SESSION['orderID'] = $_GET['orderID'];
    }

    $productsQuery = "SELECT * FROM products";
    $resultProductsQuery = mysqli_query($connection, $productsQuery);
    $nProducts = mysqli_num_rows($resultProductsQuery);
    $ean13=0;

    if (isset($_SESSION['loggedIn'])) {
        echo <<<HEREDOC

                <div id="body" class="limiter">
                    <div class="mainContainer">
                        <div class="wrap-mainContainer">
                    <div id="picContainer" class="container">
                        <img src="images/logoweb.png" id="logoweb">
                    </div>
                    <div class="workingArea">
                    <div id="time" class="container border border-dark">
                        Order: {$_SESSION['orderID']}
                    </div>
                    <div class="container border border-dark">
                    <h6 id = "hClock"></h6>
                    
                    </div>

                    <div id="itemsContainer" class="container border-start border-end border-dark">
                        <div class="row">
                            <div id="itemsSelection" class="col-9 border-dark">
                                <br>
                                <nav class="col ">
                                  
                                </nav>
                                <div class="searchbar">
                                    <input type="text" id="Input" autofocus="autofocus" onkeyup="searchbar()" placeholder="Search for products.." title="Type in a barcode">
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
                                <form action="setSessVars.php" method="GET">
                                    <div class="cart-items">
                                    </div>
                                    <div class="cart-total">
                                        <strong class="cart-total-title">Total</strong>
                                        <span class="cart-total-price">£0</span>
                                        <input hidden id="total" name="total" value="error">
                                    </div>
                                    <div class="checkoutButton">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment" id="CASH" value="CASH" checked="checked" />
                                            <label class="form-check-label" for="CASH">Cash</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment" id="CARD" value="CARD" />
                                            <label class="form-check-label" for="CARD">Card</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment" id="SAVE" value="SAVE" />
                                            <label class="form-check-label" for="SAVE">Save</label>
                                        </div>
                                        <div class="cashGiven">
                                        <label for="cashBox">Cash Given</label>
                                        <input type="number" id="cashBox" name="cashGiven" step=".01" placeholder="£0.00"/>
                                        </div>
                                        <button id="submit" class="btn btn-warning btn-lg btn-block" type="submit" disabled>Checkout</button>
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
        header("Location: login.php");
        
    }

    require "footer.php";
?>