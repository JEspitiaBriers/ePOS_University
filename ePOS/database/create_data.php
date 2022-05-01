<?php

require_once "credentials.php";
$userID = "";


//establish connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass);

//display error message if failed to connect
if (!$connection)
{
    die("Connection failed: " . $mysqli_connect_error);
}

//---START: create the database
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;

// no data returned, check for creation success/failure:
if (mysqli_query($connection, $sql))
{
    echo "Database created successfully, or already exists<br>";
}
else
{
    die("Error creating database: " . mysqli_error($connection));
}
//---END: create the database


//selects database to work with throuhght the system
mysqli_select_db($connection, $dbname);


//-----------START: table dropping (used to reset tables during development) staff -> products -> order
//---STAFF TABLE
//drop tables if it already exists
$dropStaff = "DROP TABLE IF EXISTS staff";

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $dropStaff))
{
    echo "Dropped existing table: staff<br>";
}
else
{
    die("Error checking for existing table: staff -> " . mysqli_error($connection));
}
$dropStock = "DROP TABLE IF EXISTS stock";

// no data returned, check for drop success/failure:
    if (mysqli_query($connection, $dropStock))
{
    echo "Dropped existing table: stock<br>";
}
else
{
    die("Error checking for existing table: stock -> " . mysqli_error($connection));
}

//---PRODUCTS TABLE
//drop table if it already exists
$dropProducts = "DROP TABLE IF EXISTS products";

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $dropProducts))
{
echo "Dropped existing table: products<br>";
}
else
{
die("Error checking for existing table: products -> " . mysqli_error($connection));
}

//---ORDERS TABLE
//drop table if it already exists
$dropOrders = "DROP TABLE IF EXISTS orders";

// no data returned, check for drop success/failure:
    if (mysqli_query($connection, $dropOrders))
{
    echo "Dropped existing table: orders<br>";
}
else
{
    die("Error checking for existing table: orders -> " . mysqli_error($connection));
}











//----------END: table droppping (used to reset tables during development)


//----------START: table creation
//create staff table:
$createStaff = "CREATE TABLE staff (username VARCHAR(16), firstname VARCHAR(90), lastname VARCHAR(90), job_role VARCHAR(50), password VARCHAR(16), PRIMARY KEY(username));";
///////////// --- NOTE: username can be user initials plus idnumber plus random int

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $createStaff))
{
    echo "Table created successfully: staff<br>";
}
else
{
    die("Error creating table: staff -> " . mysqli_error($connection));
}

//create products table:
$createProducts = "CREATE TABLE products (productID INT(10) AUTO_INCREMENT, product_name VARCHAR(16), price FLOAT(23), product_description VARCHAR(50), product_image VARCHAR(255), EAN13 VARCHAR(13), PRIMARY KEY(productID));";

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $createProducts))
{
    echo "Table created successfully: products<br>";
}
else
{
    die("Error creating table: products -> " . mysqli_error($connection));
}

//create orders table:
$createOrders = "CREATE TABLE orders (orderID INT(10) AUTO_INCREMENT, number_of_products SMALLINT(10), products VARCHAR(100), total_cost FLOAT(23), payment_type VARCHAR(20), payment_status VARCHAR(8), PRIMARY KEY(orderID));";
///////////// --- NOTEs: products might change into json files using orderID as file name for receipts
///////////// --- products field will be a list of product ID numbers and number of each item bought

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $createOrders))
{
    echo "Table created successfully: orders<br>";
}
else
{
    die("Error creating table: orders -> " . mysqli_error($connection));
}



$createStock = "CREATE TABLE stock(stockID INT(10) AUTO_INCREMENT, productID INT(10) NOT NULL, product_stock INT(100) NOT NULL,number_sold INT(100) NOT NULL, dateChecked DATE NOT NULL, PRIMARY KEY(stockID),CONSTRAINT FK_productID FOREIGN KEY (productID) REFERENCES products(productID) );" ;
if (mysqli_query($connection, $createStock))
{
    echo "Table created successfully: stock<br>";
}
else
{
    die("Error creating table: stock -> " . mysqli_error($connection));
}

//----------END: table creation


//----------START: table population
//testing data for staff table:
$populateBoss = "INSERT INTO staff (username, firstname, lastname, job_role, password) VALUES (
    'BB1234', 'BOSS', 'BOSS', 'BOSS', 'BOSS');";
if (mysqli_query($connection, $populateBoss))
{
    echo "row inserted BOSS (staff)<br>";
}
else
{
    die("Error inserting row: BOSS ->" . mysqli_error($connection));
}
$firstname[] = "Jamie"; $lastname[] = "Espitia Briers"; $job_role[] = "Admin"; $password[] = "Admin";
$firstname[] = "Alvaro"; $lastname[] = "Dominguez Mora"; $job_role[] = "Admin"; $password[] = "Admin";
$firstname[] = "Dylan"; $lastname[] = "Jones"; $job_role[] = "Admin"; $password[] = "Admin";
$firstname[] = "Mehadi"; $lastname[] = "Ali"; $job_role[] = "Admin"; $password[] = "Admin";
$firstname[] = "multi name"; $lastname[] = "testing function"; $job_role[] = "F&B"; $password[] = "2143";

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($firstname); $i++)
{
    $populateStaff = "INSERT INTO staff (username, firstname, lastname, job_role, password) VALUES ('". GenerateUsername($firstname[$i], $lastname[$i]) . "',
     '$firstname[$i]', '$lastname[$i]', '$job_role[$i]', '$password[$i]')";
    // no data returned, we just test for true(success)/false(failure):
    $checkQuery = "SELECT * FROM staff WHERE username = '$userID'";
    while (mysqli_num_rows(mysqli_query($connection, $checkQuery)) > 0){
        GenerateUsername($firstname[$i], $lastname[$i]);
    }
    if (mysqli_query($connection, $populateStaff))
    {
        echo "row inserted (staff)<br>";
    }
    else
    {
        die("Error inserting row: staff -> " . mysqli_error($connection));
    }
}
//generates user id from intials plus randomly generated number
function GenerateUsername ($firstname, $lastname) {
    //Concatonates names to generate ID
    $nameConcat = $firstname . " ". $lastname;
    $usernameCreate = explode(" ", $nameConcat);
    $userInitials = "";
    for($i = 0; $i < count($usernameCreate); $i++){
        $userInitials .= substr($usernameCreate[$i], 0, 1);
    }
    //generates number to add to use initals
    $idNum = rand(1000, 9999);
    $userID = $userInitials . $idNum;
    //checks if the new user id already exists in the databse
    return $userID;
}

//testing data for products table
$product_name[] = "WATER"; $price[] = "1.25"; $product_description[] = "500ml bottle of water"; $product_image[] = "images/products/water-250.png"; $EAN13[] = "5000167079470";
$product_name[] = "COKE"; $price[] = "1.00"; $product_description[] = "330ml can of coke"; $product_image[] = "images/products/coke-250.png"; $EAN13[] = "0000000000000";
$product_name[] = "FANTA"; $price[] = "1.00"; $product_description[] = "330ml can of fanta"; $product_image[] = "images/products/fanta-250.png"; $EAN13[] = "0000000000000";
$product_name[] = "REDBULL"; $price[] = "1.25"; $product_description[] = "330ml can of redbull"; $product_image[] = "images/products/redbull-250.png"; $EAN13[] = "0000000000000";
$product_name[] = "CHOCOLATE"; $price[] = "0.75"; $product_description[] = "snack size chocolate bar"; $product_image[] = "images/products/chocolatebar.png"; $EAN13[] = "0000000000000";
$product_name[] = "SHIRT M"; $price[] = "15.25"; $product_description[] = "medium sized plain shirt"; $product_image[] = "images/products/shirt.png"; $EAN13[] = "0000000000000";
$product_name[] = "BOOK"; $price[] = "10.99"; $product_description[] = "200 page book"; $product_image[] = "images/products/book.png"; $EAN13[] = "0000000000000";

for ($i = 0; $i<count($product_name); $i++){
    $populateProducts = "INSERT INTO products (productID, product_name, price, product_description, product_image, EAN13) VALUES (
        '', '$product_name[$i]', '{$price[$i]}', '$product_description[$i]', '$product_image[$i]', '$EAN13[$i]');";
    if (mysqli_query($connection, $populateProducts))
    {
        echo "row inserted (product)<br>";
    }
    else
    {
        die("Error inserting row: product -> " . mysqli_error($connection));
    }
}
//stock data
//select product ID, insert those into col along with the other data
//stock id, prodid, prod stock, num sold, datechecked
//table needs to update with this data from the json every day, alongwith a timestamp for that day so you can see its different.
//so wed need a function too for this, ticking every sec for 24 hours until it reaches it, grabs the data for that current day and updates the db tables(inserts the new rows)

$date = date("Y/m/d H:i:s");
//$date_checked[] = $date;





$id = "";
$findProducts = "SELECT * FROM products";

$findProductsExe = mysqli_query($connection,$findProducts);
while($row = mysqli_fetch_assoc($findProductsExe)){
    
    $stock_sold = rand(1,15); 
    $stock_data = rand(1,100);
    
    $id = $row["productID"];

    $populateStock = "INSERT INTO stock(productID, product_stock, number_sold, dateChecked)
     VALUES('{$id}','$stock_data','$stock_sold','{$date}');";

    if (mysqli_query($connection, $populateStock))
    {
        echo "row inserted (stock)<br>";
    }
    else
    {
        die("Error inserting row: stock -> " . mysqli_error($connection));
    }
    
}

//testing data for orders table
$number_of_products[] = "77"; $products[] = "MUST"; $total_cost[] = "197.58"; $payment_type[] = "CARD"; $payment_status[] = "AWAITING"; 
$number_of_products[] = "12"; $products[] = "IMPLEMENT"; $total_cost[] = "51.82"; $payment_type[] = "CASH"; $payment_status[] = "RECEIVED"; 
$number_of_products[] = "42"; $products[] = "JSON"; $total_cost[] = "42.00"; $payment_type[] = "CARD"; $payment_status[] = "RECEIVED"; 
for($i=0; $i<count($number_of_products); $i++){
    $populateOrders = "INSERT INTO orders (orderID, number_of_products, products, total_cost, payment_type, payment_status) VALUES (
        '' ,'$number_of_products[$i]', '$products[$i]', '$total_cost[$i]', '$payment_type[$i]', '$payment_status[$i]');";
    if (mysqli_query($connection, $populateOrders))
    {
        echo "row inserted (order)<br>";
    }
    else
    {
        die("Error inserting row: order -> " . mysqli_error($connection));
    }
}

///////////// --- NOTEs: products might change into json files using orderID as file name for receipts
///////////// --- products field will be a list of product ID numbers and number of each item bought
//----------END: table population

//close connection to database
mysqli_close($connection);
?>


 