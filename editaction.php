<?php
session_start();
include("config.php");

// Check if the customer is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the specific form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['itno'])) {
    $editItem = $_SESSION['edititem'];

    foreach ($editItem as $editItemId) {
        // Check if the specific form is submitted
        if (isset($_POST["insertedit_$editItemId"])) {
            // Sanitize the input data to prevent SQL injection
            $itno = mysqli_real_escape_string($conn, $_POST['itno']);
            $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
            $item_price = mysqli_real_escape_string($conn, $_POST['item_price']);
            $item_descrp = mysqli_real_escape_string($conn, $_POST['item_descrp']);
            $item_pic = mysqli_real_escape_string($conn, $_POST['item_pic']);

            // Update the database with the new values
            $updateQuery = "UPDATE menuitem SET item_name=?, item_price=?, item_descrp=?, item_pic=? WHERE itno=?";
            $updateitem = $conn->prepare($updateQuery);

            // Check if the preparation was successful
            if ($updateitem === false) {
                die('Error preparing statement: ' . $conn->error);
            }

            // Bind parameters
            $updateitem->bind_param("ssssi", $item_name, $item_price, $item_descrp, $item_pic, $itno);

            // Execute the update query
            $updateitem->execute();

            // Check if the update was successful
            if ($updateitem->affected_rows > 0) {
                echo "<script>
                        window.location.href = 'adminmenu.php';
                        alert('Item edited')
                        </script>";
                unset($_SESSION['edititem']);

            } else {
                echo "Failed to update item. Please try again.";
            }

            // Close the statement
            $updateitem->close();
            break; // Exit the loop after processing the specific form
        }
    }
} else {
    echo "Invalid request.";
}
?>
