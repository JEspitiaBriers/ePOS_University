<?php    



// someone please help :'[ im having issues with the $_SESSION Variable -->
//in the page linked above, i set $_SESSION['orderID'] = 0 
// but in update_order page (click the link on the button in testcheckout.php),
// the $_SESSION['orderID'] variable doesnt work.

    include "head.php";


    //DJ general notes 20/04
    //

    if (isset($_SESSION['loggedin'])) {

        echo <<<HEREDOC
            
                <form action="testcheckout.php">   
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
                                        </div>
                                    </div>
                        
                                    <div class="item">
                                        <div>
                                            <img class="img" src="images/products/coke-250.png">
                                            <div class="itemName">Coke</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <img class="img" src="images/products/fanta-250.png">
                                            <div class="itemName">Fanta</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <img class="img" src="images/products/redbull-250.png">
                                            <div class="itemName">RedBull</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <div class="img">No picture</div>
                                            <div class="itemName">Beer</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <img class="img" src="images/products/orangejuice.png">
                                            <div class="itemName">Orange Juice</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <p class="img">No picture</p>
                                            <div class="itemName">XXXXX</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <p class="img">No picture</p>
                                            <div class="itemName">XXXXX</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <p class="img">No picture</p>
                                            <div class="itemName">XXXXX</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <p class="img">No picture</p>
                                            <div class="itemName">XXXXX</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <p class="img">No picture</p>
                                            <div class="itemName">XXXXX</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <p class="img">No picture</p>
                                            <div class="itemName">XXXXX</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <p class="img">No picture</p>
                                            <div class="itemName">XXXXX</div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div>
                                            <p class="img">No picture</p>
                                            <div class="itemName">XXXXX</div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div id="checkout" class="col border-start border-dark">
                                Checkout
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