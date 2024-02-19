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
echo "    <li><a href='additempage.php'>Add Item</a></li>";
echo "    <li><a href='contact.html'>Contact</a></li>";
echo "</ul>";
echo "</nav>";
echo "</header>";
    
echo "<main>";
// Display menu items
if ($result->num_rows > 0) {
    echo "<section class='menu'>";            
    while ($row = $result->fetch_assoc()) {            
        echo "<div class='item'>";
        echo "<img src='". $row['item_pic'] . "' alt='Burger'>";
        echo "<h3>" . $row['item_name'] . "</h3>";
        echo "<p>" . $row['item_price'] . "<p>";
        echo "<p>" . $row['item_descrp'] . "<p>";
        echo "<form action='edititem.php' method='post'>";
        echo "    <input type='hidden' name='itno' value='" . $row['itno'] . "'>";
        echo "    <button type='submit' class='button' name='editnow'>EDIT</button>";
        echo "</form>";

        // Add a form for deletion
        echo "<form action='deleteitem.php' method='post'>";
        echo "    <input type='hidden' name='itno' value='" . $row['itno'] . "'>";
        echo "    <button type='submit' class='button' name='deletenow'>DELETE</button>";
        echo "</form>";

        echo "</div>";      
    }
    echo "</section>";          
} else {
    echo "No menu items available.";
}   
echo "</main>";
        // Close the database connection
    $conn->close();
?>

<footer>
    <p>&copy; Food Delivery Prototype</p>
</footer>
</main>    
</body>
</html>
