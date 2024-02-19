<?php

include("config.php");

// Taking all 5 values from the form data(input)
$itno = $_POST['itno'];
$item_name = $_POST['item_name'];
$item_price = $_POST['item_price'];
$item_descrp = $_POST['item_descrp'];
$item_pic = $_POST['item_pic'];
$sql = "INSERT INTO `menuitem`(`itno`, `item_name`, `item_price`, `item_descrp`, `item_pic`) VALUES ($itno, '$item_name', '$item_price', '$item_descrp', '$item_pic')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            window.location.href = 'adminmenu.php';
            alert('Item added')
        </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>

