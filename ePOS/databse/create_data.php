<?php

require_once "credentials.php";

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
$sql = "DROP TABLE IF EXISTS staff";

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: staff<br>";
}
else
{
    die("Error checking for existing table: " . mysqli_error($connection));
}

//---PRODUCTS TABLE
//drop table if it already exists
$sql = "DROP TABLE IF EXISTS products";

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $sql))
{
echo "Dropped existing table: products<br>";
}
else
{
die("Error checking for existing table: " . mysqli_error($connection));
}

//---ORDERS TABLE
//drop table if it already exists
$sql = "DROP TABLE IF EXISTS orders";

// no data returned, check for drop success/failure:
    if (mysqli_query($connection, $sql))
{
    echo "Dropped existing table: orders<br>";
}
else
{
    die("Error checking for existing table: " . mysqli_error($connection));
}
//----------END: table droppping (used to reset tables during development)


//----------START: table creation
//create staff table:
$sql = "CREATE TABLE staff (firstname VARCHAR(90), lastname VARCHAR(90), username VARCHAR(16), job_role VARCHAR(50), password VARCHAR(16), PRIMARY KEY(username))";
///////////// --- NOTE: username can be user initials plus idnumber plus random int

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: staff<br>";
}
else
{
    die("Error creating table: " . mysqli_error($connection));
}

//create products table:
$sql = "CREATE TABLE products (productID VARCHAR(16), product_name VARCHAR(16), price FLOAT(90), product_description VARCHAR(50), number_sold INT(), PRIMARY KEY(productID))";
///////////// --- NOTES: 
///////////// --- 

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: products<br>";
}
else
{
    die("Error creating table: " . mysqli_error($connection));
}

//create orders table:
$sql = "CREATE TABLE orders (orderID INT(10), number_of_products SMALLINT(), products VARCHAR(100), total_cost FLOAT(), payment_type VARCHAR(), payment_status BOOLEAN(), PRIMARY KEY(orderID))";
///////////// --- NOTEs: products might chnage into json files using orderID as file name for receipts
///////////// --- products field will be a list of product ID numbers and number of each item bought

// no data returned, check for drop success/failure:
if (mysqli_query($connection, $sql))
{
    echo "Table created successfully: orders<br>";
}
else
{
    die("Error creating table: " . mysqli_error($connection));
}
//----------END: table creation


//----------START: table population
//testing data for staff table:
(firstname VARCHAR(90), lastname VARCHAR(90), username VARCHAR(16), job_role VARCHAR(50), password VARCHAR(16), PRIMARY KEY(username)) 
$nameConcat[] = $firstname[] + $lastname[];
$usernameCreate = substr($nameConcat[], 0, 1);
for($i = 0; $i < strlen($nameConcat); $i++){
    if($nameConcat[$i] == " ") {
        $usernameCreate = $usernameCreate + substr($nameConcat[], strpos($nameConcat[$i]), 1);
    }
}
/* do {
    generate new rand(1000, 9999);
} while user initals + rand(1000, 9999) exists in database
$usernameCreate += rand(10000, 99999);
*/
$firstname[] = "Jamie"; $lastname[] = "Espitia Briers"; $username[] = ; $job_role[] = ; $password[] = ;

// loop through the arrays above and add rows to the table:
for ($i=0; $i<count($usernames); $i++)
{
    $sql = "INSERT INTO members (username, password, firstname, lastname, age, dob, email) VALUES ('$usernames[$i]', '$passwords[$i]', '$firstnames[$i]', '$lastnames[$i]', '$ages[$i]', '$dobs[$i]', '$emails[$i]')";

    // no data returned, we just test for true(success)/false(failure):
    if (mysqli_query($connection, $sql))
    {
        echo "row inserted<br>";
    }
    else
    {
        die("Error inserting row: " . mysqli_error($connection));
    }
}

//close connection to database
mysqli_close($connection);
?>