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
    include("config.php");

    // Check if the customer is logged in
    if (!isset($_SESSION['customer'])) {
        // Redirect to the login page if not logged in
        header("Location: login.php");
        exit();
    }

    // Fetch menu items from the database
    $sql = "SELECT itno, item_name, item_price, item_descrp, item_pic FROM menuitem";
    $result = $conn->query($sql);

    echo "<header>";
    echo "<h1>Food Delivery Service</h1>";
    echo "<a href='menu.php'><img src='login.png' alt='Login' class='login-image'></a>";
    echo "<a href='menu.php' class='loginemail'>" . $_SESSION['customer']['email'] . "</a><br><br>";
    echo "<a href='logout.php' class='logoutb'>Logout</a>";
    echo "<nav>";
    echo "<ul>";
    echo "    <li><a href='menu.php'>Menu</a></li>";
    echo "    <li><a href='contact.php'>Contact</a></li>";
    echo "    <li><a href='checkout.php'>CHECKOUT</a></li>";
    echo "</ul>";
    echo "</nav>";
    echo "</header>";
    echo " <main>";
    // Display menu items
    if ($result->num_rows > 0) {
        echo "<section class='menu'>";
        while ($row = $result->fetch_assoc()) {
            
            echo "<div class='item'>";
            echo "<img src='" . $row['item_pic'] . "' alt='Burger'>";
            echo "<h3>" . $row['item_name'] . "</h3>";
            echo "<p>" . $row['item_price'] . "<p>";
            echo "<p>" . $row['item_descrp'] . "<p>";
            echo "<form action='menu.php' method='post'>";
            echo "    <input type='hidden' name='itno' value='" . $row['itno'] . "'>";
            echo "    <button type='submit' class='button' name='orderNow'>Order Now</button>";
            echo "</form>";
            echo "</div>";
            
        }
        echo "</section>";
    } else {
        echo "No menu items available.";
    }

    // Handle adding products to the cart
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['itno']) && isset($_POST['orderNow'])) {
        $productId = $_POST['itno'];

        // Ensure $_SESSION['cartItem'] is an array
        if (!isset($_SESSION['cartItem']) || !is_array($_SESSION['cartItem'])) {
            $_SESSION['cartItem'] = [];
        }

        // Add product to the cart in the 'cartItem' session if it's not already added
        if (!in_array($productId, $_SESSION['cartItem'])) {
            $_SESSION['cartItem'][] = $productId;
        }

        // Redirect back to the menu after adding to the cart
        echo "<script>
                
                alert('Item added to cart')
                </script>";
        exit();
    }   
    echo "</main>";
?>

   
</body>
</html>
