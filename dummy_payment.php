<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy Payment - Food Delivery Prototype</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
session_start();
$_SESSION['order_details'] = [
    'address' => $_POST['address'],
    'city' => $_POST['city'],
    'country' => $_POST['country']
];
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
            
            // Display the card details form if not provided
            
            
            echo "<header>";
            echo "<h1>Food Delivery Service</h1>";
            echo "</header>";
            
            echo "<main>";
            echo "<h2>Enter Card Details</h2>";
            echo "<form action='orders.php' method='post'>";
            echo "    <label for='card_number'>Card Number:</label>";
            echo "    <input type='text' id='card_number' name='card_number' required><br>";
            echo "    <label for='expiry_date'>Expiry Date:</label>";
            echo "    <input type='text' id='expiry_date' name='expiry_date' placeholder='MM/YYYY' required><br>";
            echo "    <label for='cvv'>CVV:</label>";
            echo "    <input type='text' id='cvv' name='cvv' required><br>";
            echo "<h2>Checkout Address</h2>";
            echo "<p>Address: {$_POST['address']}</p>";
            echo "<p>City: {$_POST['city']}</p>";
            echo "<p>Country: {$_POST['country']}</p>";
            $totalPrice = $_POST['totalPrice'];
            echo "<h3>" . $totalPrice . "</h3>";
             
            echo "    <button type='submit' class='button'>Submit Payment</button>";
            echo "</form>";
            echo "</main>";
            echo "<footer>";
            echo "<p>&copy; Food Delivery Prototype</p>";
            echo "</footer>";
           
        }
     else {
        // Redirect to the checkout page if the form is not submitted
        header("Location: orders.php");
        exit();
    }
?>
</body>
</html>
