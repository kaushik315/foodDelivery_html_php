<?php

include("config.php");

// Taking all 5 values from the form data(input)
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];
$is_admin = isset($_POST['is_admin']) ? 1 : 0;
$sql = "INSERT INTO `user`(`userno`, `fname`, `lname`, `email`, `password`, `is_admin`) VALUES ('1', '$fname', '$lname', '$email', '$password', '$is_admin')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            window.location.href = 'login.html';
            alert('User Registered')
        </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>

