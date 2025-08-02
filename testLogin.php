<?php
session_start();


if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['password'])) {
  include_once('config.php');

  $email = $_POST['email'];
  $password = $_POST['password'];


// Usando prepared statement para evitar SQL Injection
$stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if(mysqli_num_rows($result) < 1)
{
  unset($_SESSION['email']);
  unset($_SESSION['password']);
 header("Location: login.php");
}
else
{
  $_SESSION['email'] = $email;
  $_SESSION['password'] = $password;
  header("Location: sistema.php");
}



  
}
else
 {  
    header("Location: login.php");

}




?>