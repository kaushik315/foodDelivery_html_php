<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Checkout - Food Delivery Prototype</title>
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

    echo "<header>";
    echo "<h1>Food Delivery Service</h1>";

    // Check if the customer is logged in and has an email
    if (isset($_SESSION['customer']['email'])) {
        echo "<a href='menu.php' class='loginemail'>" . $_SESSION['customer']['email'] . "</a>";
    } else {
        // Redirect to the login page if not logged in
        header("Location: login.php");
        exit();
    }
    echo "<a href='menu.php'><img src='login.png' alt='Login' class='login-image'></a>";
    echo "<a href='logout.php' class='logoutb'>Logout</a>";
    echo "<nav>";
    echo "<ul>";
    echo "    <li><a href='menu.php'>Menu</a></li>";
    echo "    <li><a href='contact.php'>Contact</a></li>";
    echo "</ul>";
    echo "</nav>";
    echo "</header>";

    echo "<main>";


    // Display the items in the cart
    echo "<h2>Shopping Cart</h2>";
    $totalPrice=0;
    // Check if the cart is empty
    if (empty($_SESSION['cartItem'])) {
        echo "<p>Your cart is empty.</p>";
    } else {
        // Fetch details of items in the cart from the database
    $cartItems = $_SESSION['cartItem'];

    // Create a string with placeholders for each product ID
    $placeholders = '';
    foreach ($cartItems as $index => $cartItem) {
        $placeholders .= ($index > 0 ? ',' : '') . '?';
    }
    // Query to fetch details of items in the cart
    $query = "SELECT itno, item_name, item_price FROM menuitem WHERE itno IN ($placeholders)";

    // Prepare the statement
    $stmt = $conn->prepare($query);

    // Check if the preparation was successful
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Execute the query with values directly interpolated into the SQL
    $stmt->execute($cartItems);

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>{$row['item_name']} - \${$row['item_price']}</p>";
        }
    } else {
        echo "No items in the cart.";
    }

    // Calculate the total price (dummy calculation)
    $totalPrice = 0;
    foreach ($result as $row) {
        $totalPrice += $row['item_price'];
    }

    echo "<h3>Total Price: \${$totalPrice}</h3>";
    }
    

    echo "<form action='dummy_payment.php' method='post'>";
    echo "<input type='hidden' name='totalPrice' value='{$totalPrice}'>";
    echo "<h2>Checkout Address</h2>";
    echo "    <label for='address'>Address:</label>";
    echo "    <input type='text' id='address' name='address' required><br>";
    echo "    <label for='city'>City:</label>";
    echo "    <input type='text' id='city' name='city' required><br>";
    echo "    <label for='country'>Country:</label>";
    echo "    <input type='text' id='country' name='country' required><br>";
    
    echo "<button type='submit' class='button'>Proceed to Payment</button>";
    echo "</form>";

    echo "</main>";

  
?>
<footer>
    <p>&copy; Food Delivery Prototype</p>
</footer>
</body>
</html>
