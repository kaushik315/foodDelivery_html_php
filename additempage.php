<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!--This document is encoded using UTF-8-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--This line makes the webpage responsive across all devices-->
    <title>Menu - Food Delivery Prototype</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
// Start the session
session_start();
include ("config.php");
// Check if the customer is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}
// Fetch menu items from the database
$sql = "SELECT itno, item_name, item_price, item_descrp, item_pic FROM menuitem";
$result = $conn->query($sql);
echo "<header>";
echo "<h1>Food Delivery Service</h1>";
echo "<a href='adminmenu.php'><img src='login.png' alt='Login' class='login-image'></a>";
echo "<a href='adminmenu.php' class='loginemail'>" . $_SESSION['admin']['email'] . "</a>";
echo "<a href='logout.php' class='logoutb'>Logout</a>";
echo "<nav>";
echo "<ul>";
echo "    <li><a href='adminmenu.php'>Menu</a></li>";
echo "    <li><a href='contact.html'>Contact</a></li>";
echo "</ul>";
echo "</nav>";
echo "</header>";
    
echo "<main>";
echo "<section class='form'>";
echo "<form action='additem.php' method='post'>";
echo "<h2>ADD ITEM</h2>";
echo "<label for='itno'>Item number:</label><br>";
echo "<input type='text' id='itno' name='itno'><br>";
echo "<label for='item_name'>Item name:</label><br>";
echo "<input type='text' id='item_name' name='item_name'><br><br>";
echo "<label for='item_price'>Price:</label><br>";
echo "<input type='text' id='item_price' name='item_price'><br><br>";
echo "<label for='item_descrp'>Item Description:</label><br>";
echo "<input type='text' id='item_descrp' name='item_descrp'><br><br>";
echo "<label for='item_pic'>Location of Item Image:</label><br>";
echo "<input type='text' id='item_pic' name='item_pic'><br><br>";
echo "<input type='submit'>";
echo "</form>";
echo "</section>";
?>

<footer>
    <p>&copy; Food Delivery Prototype</p>
</footer>
</main>    
</body>
</html>
