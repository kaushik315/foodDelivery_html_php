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
    if (!isset($_SESSION['admin'])) {
        // Redirect to the login page if not logged in
        header("Location: login.php");
        exit();
    }

    echo "<header>";
    echo "<h1>Food Delivery Service</h1>";

    // Check if the customer is logged in and has an email
    if (isset($_SESSION['admin']['email'])) {
        echo "<a href='login.php' class='login-image1' class='loginemail'>" . $_SESSION['admin']['email'] . "</a>";
    } else {
        // Redirect to the login page if not logged in
        header("Location: login.php");
        exit();
    }

    echo "<a href='logout.php' class='logoutb'>Logout</a>";
    echo "<a href='adminmenu.php'>MENU</a>";
    echo "<nav>";
    echo "<ul>";
    echo "    <li><a href='adminmenu.php'>Menu</a></li>";
    echo "    <li><a href='contact.php'>Contact</a></li>";
    echo "</ul>";
    echo "</nav>";
    echo "</header>";

    echo "<main>";

    // Display the items in the edititem
    echo "<h2>EDIT ITEM</h2>";
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['itno']) && isset($_POST['editnow'])) {
        $productId = $_POST['itno'];

        // Ensure $_SESSION['edititem'] is an array
        if (!isset($_SESSION['edititem']) || !is_array($_SESSION['edititem'])) {
            $_SESSION['edititem'] = [];
        }

        // Add product to the cart in the 'edititem' session if it's not already added
        if (!in_array($productId, $_SESSION['edititem'])) {
            $_SESSION['edititem'][] = $productId;
        }

        // Fetch details of items in the cart from the database
        $editItem = $_SESSION['edititem'];

        // Create a string with placeholders for each product ID
        $placeholders = str_repeat('?,', count($editItem) - 1) . '?';

        // Query to fetch details of items in the cart
        $query = "SELECT itno, item_name, item_price, item_descrp, item_pic FROM menuitem WHERE itno IN ($placeholders)";

        // Prepare the statement
        $stmt = $conn->prepare($query);

        // Check if the preparation was successful
        if ($stmt === false) {
            die('Error preparing statement: ' . $conn->error);
        }

        // Dynamically bind parameters using call_user_func_array
        $bindParams = array(str_repeat('s', count($editItem)));

        foreach ($editItem as &$editItemId) {
            $bindParams[] = &$editItemId;
        }

        // Bind parameters
        call_user_func_array(array($stmt, 'bind_param'), $bindParams);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<form action='editaction.php' method='post'>";
                echo "<label for='itno'>Item number:</label><br>";
                echo "<input type='text' id='itno' name='itno' value='{$row['itno']}'><br>";
                echo "<label for='item_name'>Item name:</label><br>";
                echo "<input type='text' id='item_name' name='item_name' value='{$row['item_name']}'><br><br>";
                echo "<label for='item_price'>Price:</label><br>";
                echo "<input type='text' id='item_price' name='item_price' value='{$row['item_price']}'><br><br>";
                echo "<label for='item_descrp'>Item Description:</label><br>";
                echo "<input type='text' id='item_descrp' name='item_descrp' value='{$row['item_descrp']}'><br><br>";
                echo "<label for='item_pic'>Location of Item Image:</label><br>";
                echo "<input type='text' id='item_pic' name='item_pic' value='{$row['item_pic']}'><br><br>";
                // Add itno to form and submit button names
                echo "<input type='submit' class='button' name='insertedit_{$row['itno']}'>";
                echo "</form>";
            }

            
        } else {
            echo "No items in the cart.";
        }
    } 

    echo "</main>";

?>
<footer>
    <p>&copy; Food Delivery Prototype</p>
</footer>
</body>
</html>
