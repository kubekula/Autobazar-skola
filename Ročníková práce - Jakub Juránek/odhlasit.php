<?php
session_start();

$_SESSION['prezdivka'] = "";        
unset($_SESSION['prezdivka']);
header("Location: index.php");
exit();
?>
