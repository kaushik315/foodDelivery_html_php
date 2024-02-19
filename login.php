<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!--This document is encoded using UTF-8-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!--This line makes the webpage responsive across all devices-->
    <title>Login - Food Delivery Prototype</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php
            // Start the session
            session_start();
            include ("config.php");
                echo "<header>";
                echo "<h1>Food Delivery Service</h1>";
                echo "<a href='login.html'><img src='login.png' alt='Login' class='login-image'></a>";
                echo "<nav>";
                echo "<ul>";
                echo "    <li><a href='login.php'>Menu</a></li>";
                echo "    <li><a href='contact.php'>Contact</a></li>";
                echo "</ul>";
                echo "</nav>";
                echo "</header>";
            

            echo "<main>";
            echo "<section class='form'>";
            echo "<h2>Login</h2>";
            echo "<form method='post'>";
            echo "<label for='email'>E-mail:</label><br>";
            echo "<input type='email' id='email' name='email'><br><br>";
            echo "<label for='password'>Password:</label><br>";
            echo "<input type='password' id='password' name='password'><br><br>";
            echo "<a href='register.html'>Not registered yet?</a><br><br>";
            echo "<input type='submit' value='login'>";
            echo "</form>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email=? AND password=?";
    $cred = $conn->prepare($sql);
    $cred->bind_param("ss", $email, $password);
    $cred->execute();
    $result = $cred->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['is_admin'] == 1) {
            $_SESSION['admin'] = $row;
            $_SESSION['edititem'] = null;
            header('Location: adminmenu.php');
        } else {
            $_SESSION['customer'] = $row;
            $_SESSION['cartItem'] = null;
            $_SESSION['order_details'] = null;
            header('Location: menu.php');
        }
    } else {
        echo '<script>
                alert("Login Failed. Check Username or password");
            </script>';
    }

    $cred->close();
    $conn->close();
}
?>

            
        </section>
    </main>
    <footer>
        <p>&copy; Food Delivery Prototype</p>
    </footer>
</body>
</html>
