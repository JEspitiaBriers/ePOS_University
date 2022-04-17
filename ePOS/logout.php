<?php

session_start();

//just in case a user navigates to this page without being logged in
if (isset($_SESSION['loggedin'])) { 

$_session = array();
setcookie(session_name(), '', time() - 2592000, '/');
session_destroy();

echo "You have been logged out. Redirecting to the main page...";
header("Refresh:1; url=index.php");
    
  }
  
else{  
  
//Just in case the user access logout.php before logging in
echo "You were not logged in";


}
?> 