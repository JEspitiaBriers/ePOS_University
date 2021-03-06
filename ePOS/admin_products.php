<?php
require 'head.php';
require_once 'database/credentials.php';

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//class was container-fluid, maybe a bootstrap thing idk
echo <<<_END


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
            <div class = "fluid-container">
            <table class = "styled-CSS" cellpadding='2' cellspacing ='2'>
            <thead>
                <tr>

                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
_END;


$query = "SELECT * FROM products";


/*
<th>Product Image</th>
<td><img src =../".$rows['product_image']." alt = ''</img></td>

 <img class = "img_responsive" src ="'.$rows['product_image'].'" alt = "">
*/
$results = mysqli_query($connection, $query);
while($rows = mysqli_fetch_assoc($results)){
    echo "<tr>";
    echo "<td>{$rows['productID']}</td><td>{$rows['product_name']}</td><td>{$rows['product_description']}</td><td>{$rows['price']}</td>"; 
    
    echo '<td>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal'.$rows['productID'].'">Edit</button>

    <div class="modal fade"id="editModal'.$rows['productID'].'" tabindex="-1" aria-labelledby="editModalLabel'.$rows['productID'].'" aria-hidden="true">
    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Product Information</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method = "POST" action ="admin/edit_products.php">


                                    <label for="productID" id ="productID">Product ID</label></br>
                                    <input name="productID" type="text" value ="'.$rows['productID'].'"><br/>

                                    <label for="product_name" id ="product_name">Product Name</label></br>
                                    <input name="product_name" type="text" value ="'.$rows['product_name'].'"><br/>

                                    <label for="product_description" id ="product_description">Description</label></br>
                                    <input name="product_description" type="text" value ="'.$rows['product_description'].'"><br/>

                                    <label for="price" id ="price">Price</label></br>
                                    <input name="price" type="text" value ="'.$rows['price'].'"><br/>

                        </div>
                        <form class="modal-footer" method="POST" action="admin/edit_products.php">
                            <button type="submit" class="btn btn-success" name="prod" value="'.$rows['productID'].'">Submit Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                </div>
            </div>
        </div> 
        </td>';







    echo '<td>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal'.$rows['productID'].'">Delete</button> 
            
            <div class="modal fade"id="deleteModal'.$rows['productID'].'" tabindex="-1" aria-labelledby="deleteModalLabel'.$rows['productID'].'" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Product?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body">
                            <p>Are you sure you want to delete this product? All data will be lost, including number of this item sold. This action cannot be undone.</p>
                        </div>
                        <form class="modal-footer" method="POST" action="admin/delete_products.php">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger" name="prod" value="'.$rows['productID'].'">Yes</button>
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
    </table>
    </div>
_END;

require 'footer.php';

?>