<?php


  session_start();
  

  $username="";
  $UserMatch = false; 
  $fullMatch = false;
  $username_validation_errors="";
  $password_validation_errors="";
  $total_validation_errors='';

  include_once "database/credentials.php";
  include_once "validation.php";

  //this is just in case the user manually visits again login.php
  if (isset($_SESSION['loggedin'])) {
      $showForm = false;
      echo "You are logged in!";
      echo "<br>";
      echo "Redirecting to ePOS";
      header("Refresh:2; url=orders.php");

  } else {
      $showForm = true;
  }



  echo <<<HEREDOC
      <head>
          <title>Login - ePOS</title>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          
          <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
          <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
          <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
          <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
          <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
          <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
          <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
          <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
          <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
          <link rel="stylesheet" type="text/css" href="css/util.css">
          <link rel="stylesheet" type="text/css" href="css/main.css">
      </head>

      <body>

          <div class="limiter">
              <div class="container-login100">
                  <div class="wrap-login100">
  HEREDOC;

  if(isset($_POST['username']) && isset($_POST['password'])) {

      $username = $_POST['username'];
      $passwordInput = $_POST['password'];

     

      $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        
      if (!$connection)
        {
          die("Connection failed: " . $mysqli_connect_error);
        }

      //sanitise function on validation.php
      $username = sanitise($username, $connection);
      $passwordInput = sanitise($passwordInput, $connection);

      //validating length of the strings and obtaining errors
      $username_validation_errors = validateString($username, 1, 32);
      $password_validation_errors = validateString($passwordInput, 1, 64);
      $total_validation_errors = $username_validation_errors . $password_validation_errors;

      if ($total_validation_errors == "") {

        $queryUsername = "SELECT username FROM staff WHERE username = '$username'";
        //If this exist then we can continue, if not, user not found
        $arrayResultQueryUsername = mysqli_query($connection, $queryUsername);
        $NResultsUsername = mysqli_num_rows($arrayResultQueryUsername);
        if(isset($_POST['username']) && ($NResultsUsername == 0)){
          echo "The username is incorrect<br><br>";
        }
        else if(isset($_POST['username']) && ($NResultsUsername == 1)){
          $UserMatch = true;
        }
        if ($UserMatch == true){
          $passwordQuery = "SELECT password FROM staff WHERE username = '$username'";
          $resultPasswordQuery = mysqli_query($connection, $passwordQuery);
          // no need to  fetch as this will only return one result

          foreach ($resultPasswordQuery as $row) //it will only be executed once as the query only should return one result
          {//($row['password'] == $_POST['password'])
            if ($passwordInput === $row['password']){
                $fullMatch = true; 
            }
            else{
              echo "This password is incorrect<br><br>";   
            }
          }
          if ($fullMatch == true) {
            $showForm = false;
            $_SESSION['loggedin'] = true; 

            $_SESSION['username'] = $_POST['username'];

            echo "Welcome {$_SESSION['username']}";
            //redirect to main after 3 secs
            header("Refresh:2; url=orders.php");

            //query to save the database ID number in the session
//
  //          $uidQuery = "SELECT uid FROM users WHERE username = '{$_POST['username']}'";
    //        $resultUidQuery = mysqli_query($connection, $uidQuery);
            //we save the user ID in the session as we will need this for future queries
      //      foreach ($resultUidQuery as $row){
        //      $_SESSION['uid'] = $row['uid'];
          //  }

          }
          mysqli_close($connection);         
          }
      }
      else{
      echo "<b>Validation error!";
            echo "$total_validation_errors";
            $show_signin_form = true;
      }
    }
      if ($showForm == true){
        echo <<<HEREDOC

                              <form action="login.php" method="POST" class="login100-form validate-form">
                                  <span class="login100-form-title p-b-26">
                                      ePos v0.1
                                  </span>
                                  <span class="login100-form-title p-b-48">
                                          <img src="images/logoweb.png">
                                  </span>

                                  <div class="wrap-input100 validate-input">
                                      <input class="input100" type="text" name="username" value="$username" >
                                      <span class="focus-input100" data-placeholder="Username"></span>
                                  </div>

                                  <div class="wrap-input100 validate-input" data-validate="Enter password">
                                      <span class="btn-show-pass">
                                          <i class="zmdi zmdi-eye"></i>
                                      </span>
                                      <input class="input100" type="password" name="password">
                                      <span class="focus-input100" data-placeholder="Password"></span>
                                  </div>

                                  <div class="container-login100-form-btn">
                                      <div class="wrap-login100-form-btn">
                                          <div class="login100-form-bgbtn"></div>
                                          <button class="login100-form-btn">
                                              Login
                                          </button>
                                      </div>
                                  </div>
                              </form>
        HEREDOC;
      }

      echo <<<HEREDOC
      
                          </div>
                      </div>
                  </div>


                  <div id="dropDownSelect1"></div>

                  
                  <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
                  <script src="vendor/animsition/js/animsition.min.js"></script>
                  <script src="vendor/bootstrap/js/popper.js"></script>
                  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
                  <script src="vendor/select2/select2.min.js"></script>
                  <script src="vendor/daterangepicker/moment.min.js"></script>
                  <script src="vendor/daterangepicker/daterangepicker.js"></script>
                  <script src="vendor/countdowntime/countdowntime.js"></script>
                  <script src="js/main.js"></script>

              </body>

              </html>
      HEREDOC;

?>