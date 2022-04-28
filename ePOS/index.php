<?php
    include "head.php";


    //DJ general notes 20/04
    //

    if (isset($_SESSION['loggedin'])) {

        echo <<<HEREDOC
            
                <form action="update_order.php">   
                <input type="submit" value="Checkout">
                </form>
                <a href="logout.php">Logout</a>
            

                <body>
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
                                    <div class="item">
                                        <div>
                                            <img class="img"src="images/products/water-250.png">
                                            <div class="itemName">Water</div>
                                            <div class="itemDetails">
                                                <span hidden class="itemPrice">0.75</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div>
                                            <img class="img"src="images/products/coke-250.png">
                                            <div class="itemName">Coke</div>
                                            <div class="itemDetails">
                                                <span hidden class="itemPrice">1.50</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div>
                                            <img class="img"src="images/products/fanta-250.png">
                                            <div class="itemName">Fanta</div>
                                            <div class="itemDetails">
                                                <span hidden class="itemPrice">1.50</span>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="item">
                                        <div>
                                            <img class="img"src="images/products/redbull-250.png">
                                            <div class="itemName">RedBull</div>
                                            <div class="itemDetails">
                                                <span hidden class="itemPrice">2.50</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div>
                                            <div class="img">No picture</div>
                                            <div class="itemName">Beer</div>
                                            <div class="itemDetails">
                                                <span hidden class="itemPrice">3.50</span>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="item">
                                        <div>
                                            <img class="img"src="images/products/orangejuice.png">
                                            <div class="itemName">Orange Juice</div>
                                            <div class="itemDetails">
                                                <span hidden class="itemPrice">1.20</span>
                                            </div>
                                        </div>
                                    </div>

                                
                                </div>
                            </div>
                            <div id="checkout" class="col border-start border-dark">
                                Checkout

                                <div class="cart-items">
                                </div>
                                <div class="cart-total">
                                    <strong class="cart-total-title">Total</strong>
                                    <span class="cart-total-price">£0</span>
                                </div>
                                <button class="btn btn-primary btn-purchase" type="button">Checkout</button>
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