<?php

require_once("credentials.php");
$userID = "";

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
$createProducts = "CREATE TABLE products (productID INT(10) AUTO_INCREMENT, product_name VARCHAR(16), price FLOAT(23), product_description VARCHAR(50), product_image VARCHAR(30), number_sold INT(10), PRIMARY KEY(productID));";

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
$createOrders = "CREATE TABLE orders (orderID INT(10) AUTO_INCREMENT, number_of_products SMALLINT(10), products VARCHAR(100), total_cost FLOAT(23), payment_type VARCHAR(20), payment_status BOOLEAN, PRIMARY KEY(orderID));";
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
$product_name[] = "water"; $price[] = "1.25"; $product_description[] = "500ml bottle of water"; $product_image[] = "ePOS/images/water-250.png"; $number_sold[] = "21854";
$product_name[] = "coke"; $price[] = "1.00"; $product_description[] = "330ml can of coke"; $product_image[] = "ePOS/images/coke-250.png"; $number_sold[] = "37854";
$product_name[] = "fanta"; $price[] = "1.00"; $product_description[] = "330ml can of fanta"; $product_image[] = "ePOS/images/fanta-250.png"; $number_sold[] = "31500";
$product_name[] = "redbull"; $price[] = "1.25"; $product_description[] = "330ml can of redbull"; $product_image[] = "ePOS/images/redbull-250.png"; $number_sold[] = "11023";
$product_name[] = "chocolate bar"; $price[] = "0.75"; $product_description[] = "snack size chocolate bar"; $product_image[] = "ePOS/images/noImage-250.png"; $number_sold[] = "17697";
$product_name[] = "shirt M"; $price[] = "15.25"; $product_description[] = "medium sized plain shirt"; $product_image[] = "ePOS/images/noImage-250.png"; $number_sold[] = "891";
$product_name[] = "book"; $price[] = "10.99"; $product_description[] = "200 page book"; $product_image[] = "ePOS/images/noImage-250.png"; $number_sold[] = "3";
for ($i = 0; $i<count($product_name); $i++){
    $populateProducts = "INSERT INTO products (productID, product_name, price, product_description, product_image, number_sold) VALUES (
        '', '$product_name[$i]', '$price[$i]', '$product_description[$i]', '$product_image[$i]', '$number_sold[$i]');";
    if (mysqli_query($connection, $populateProducts))
    {
        echo "row inserted (product)<br>";
    }
    else
    {
        die("Error inserting row: product -> " . mysqli_error($connection));
    }
}


//testing data for orders table
$number_of_products[] = "77"; $products[] = "MUST"; $total_cost[] = "197.58"; $payment_type[] = "CARD"; $payment_status[] = "0"; 
$number_of_products[] = "12"; $products[] = "IMPLEMENT"; $total_cost[] = "51.82"; $payment_type[] = "CASH"; $payment_status[] = "1"; 
$number_of_products[] = "42"; $products[] = "JSON"; $total_cost[] = "42.00"; $payment_type[] = "CARD"; $payment_status[] = "1"; 
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