<?php
    session_start();
    unset($_SESSION['cartItem']);
    unset($_SESSION['order_details']);
    header('Location: menu.php');
?>