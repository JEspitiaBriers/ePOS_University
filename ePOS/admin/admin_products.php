<?php
require '../head.php';
require_once '../database/credentials.php';

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
                    <th>Description</th>
                    <th>Price</th>
                    <th>Number Sold</th>
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
    echo "<td>{$rows['product_image']}</td><td>{$rows['productID']}</td><td>{$rows['product_name']}</td><td>{$rows['product_description']}</td><td>{$rows['price']}</td><td>{$rows['number_sold']}</td>"; 
    
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
                                <form method = "POST" action ="edit_products.php">

                                    <img class = "img_responsive" src ='.$rows['product_image'].' alt = "">

                                    <label for="productID" id ="productID">Product ID</label></br>
                                    <input name="productID" type="text" value ="'.$rows['productID'].'"><br/>

                                    <label for="product_name" id ="product_name">Product Name</label></br>
                                    <input name="product_name" type="text" value ="'.$rows['product_name'].'"><br/>

                                    <label for="product_description" id ="product_description">Description</label></br>
                                    <input name="product_description" type="text" value ="'.$rows['product_description'].'"><br/>

                                    <label for="price" id ="price">Price</label></br>
                                    <input name="price" type="text" value ="'.$rows['price'].'"><br/>

                                    <label for="number_sold" id ="number_sold">Number Sold</label></br>
                                    <input name="number_sold" type="text" value ="'.$rows['number_sold'].'"><br/>
                        </div>
                        <form class="modal-footer" method="POST" action="edit_products.php">
                            <button type="submit" class="btn btn-success" name="user" value="'.$rows['productID'].'">Submit Changes</button>
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
                        <form class="modal-footer" method="POST" action="delete_products.php">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" name="user" value="'.$rows['productID'].'">Yes</button>
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

//require 'footer.php';

?>