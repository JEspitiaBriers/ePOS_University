<?php
require 'header.php';
require_once 'credentials.php';


$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//class was container-fluid, maybe a bootstrap thing idk
echo <<<_END
        <div class = "fluid-container">
            <table class = "styled-CSS" cellpadding='2' cellspacing ='2'>
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Barcode Number EMPTY NO USE</th>
                </tr>
            </thead>
            <tbody>
_END;


$query = "SELECT * FROM products";

//edit_products.php does not exist as of 19/04.
//nor delete_products.php.
$results = mysqli_query($connection, $query);
while($rows = mysqli_fetch_assoc($results)){
    echo "<tr>";
    echo "<td>{$rows['pimage']}</td><td>{$rows['pid']}</td><td>{$rows['productName']}</td><td>{$rows['price']}</td><td>{$rows['quantity']}"; 
    
    echo '<td>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal'.$rows['uid'].'">Edit</button>

    <div class="modal fade"id="editModal'.$rows['uid'].'" tabindex="-1" aria-labelledby="editModalLabel'.$rows['uid'].'" aria-hidden="true">
    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit User Information</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method = "POST" action ="edit_users.php">
                                    <label for="uid" id ="uid">User ID</label></br>
                                    <input name="uid" type="text" value ="'.$rows['uid'].'"><br/>

                                    <label for="username" id ="username">Username</label></br>
                                    <input name="username" type="text" value ="'.$rows['username'].'"><br/>

                                    <label for="password" id ="password">User Password</label></br>
                                    <input name="password" type="text" value ="'.$rows['password'].'"><br/>

                                    <label for="firstname" id ="firstname">First name</label></br>
                                    <input name="firstname" type="text" value ="'.$rows['firstname'].'"><br/>

                                    <label for="lastname" id ="lastname">Last name</label></br>
                                    <input name="lastname" type="text" value ="'.$rows['lastname'].'"><br/>
                        </div>
                        <form class="modal-footer" method="POST" action="edit_users.php">
                            <button type="submit" class="btn btn-success" name="user" value="'.$rows['uid'].'">Submit Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                </div>
            </div>
        </div> 
        </td>';







    echo '<td>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal'.$rows['uid'].'">Delete</button> 
            
            <div class="modal fade"id="deleteModal'.$rows['uid'].'" tabindex="-1" aria-labelledby="deleteModalLabel'.$rows['uid'].'" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete User?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                            <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                        </div>
                        <form class="modal-footer" method="POST" action="delete_user.php">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="user" value="'.$rows['uid'].'">Yes</button>
                        </form>
                    </div>
                </div>
            </div>


    </td>';

    echo "</tr>";
    
}

echo <<<_END
    </tbody>
    </thead>
    <div>
_END;

require 'footer.php';

?>