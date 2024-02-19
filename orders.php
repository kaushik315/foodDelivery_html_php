<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Food Delivery Prototype</title>
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
        header("Location: loginac.php");
        exit();
    }

    // Fetch menu items from the database
    $sql = "SELECT itno, item_name, item_price, item_descrp, item_pic FROM menuitem";
    $result = $conn->query($sql);

    echo "<header>";
    echo "<h1>Food Delivery Service</h1>";
    echo "<a href='customermenu.php'><img src='login.png' alt='Login' class='login-image'></a>";
    echo "<a href='login.php' class='loginemail'>" . $_SESSION['customer']['email'] . "</a><br><br>";
    echo "<a href='logout.php' class='logoutb'>Logout</a>";
    echo "<nav>";
    echo "<ul>";
    echo "    <li><a href='menu.php'>Menu</a></li>";
    echo "    <li><a href='contact.php'>Contact</a></li>";
    echo "    <li><a href='checkout.php'>CHECKOUT</a></li>";
    echo "</ul>";
    echo "</nav>";
    echo "</header>";


    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        echo "<main>";
        
        echo "<h2>Payment Details</h2>";
        echo "<p>Card Number: {$_POST['card_number']}</p>";
        echo "<p>Expiry Date: {$_POST['expiry_date']}</p>";
        echo "<p>CVV: {$_POST['cvv']}</p>";

        $orderDetails = $_SESSION['order_details'];
        // Check if the cart is empty
    if (empty($_SESSION['order_details'])) {
        echo "<p>Address is empty</p>";
    } else {
        echo "<h2>Checkout Address</h2>";
        echo "<p>Address: {$orderDetails['address']}</p>";
        echo "<p>City: {$orderDetails['city']}</p>";
        echo "<p>Country: {$orderDetails['country']}</p>";
    }
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

        echo "<p>Payment Successful! Thank you for your order.</p>";
        echo "</main>";
        echo "<form action='clearmemory.php' method='post'>";
        echo "<button type='submit' class='button'>Continue</button>";
        echo "</form>";
        
            }
        echo "<footer>";
        echo "<p>&copy; Food Delivery Prototype</p>";
        echo "</footer>";
?>
</body>
</html>
