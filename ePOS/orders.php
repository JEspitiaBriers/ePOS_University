<?php
    include "head.php";



 


    if (isset($_SESSION['loggedin'])) {

        echo <<<HEREDOC
                
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
                    
                   
                        <div id="bottomMemu" class="container">
                            
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