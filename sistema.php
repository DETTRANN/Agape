<?php 
session_start();


if(!isset($_SESSION['email']) or !isset($_SESSION['password'])) 
{
    header("Location: login.php");
    exit();
}

$logado = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>