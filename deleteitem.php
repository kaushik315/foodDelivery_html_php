<?php
session_start();
include("config.php");

// Check if the customer is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the specific form for deletion is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['itno']) && isset($_POST['deletenow'])) {
    // Sanitize the input data to prevent SQL injection
    $itno = mysqli_real_escape_string($conn, $_POST['itno']);

    // Delete the item from the database
    $deleteQuery = "DELETE FROM menuitem WHERE itno=?";
    $deleteItem = $conn->prepare($deleteQuery);

    // Check if the preparation was successful
    if ($deleteItem === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind parameters
    $deleteItem->bind_param("i", $itno);

    // Execute the delete query
    $deleteItem->execute();

    // Check if the deletion was successful
    if ($deleteItem->affected_rows > 0) {
        echo "<script>
                window.location.href = 'adminmenu.php';
                alert('Item deleted')
                </script>";
    } else {
        echo "Failed to delete item. Please try again.";
    }

    // Close the statement
    $deleteItem->close();
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
