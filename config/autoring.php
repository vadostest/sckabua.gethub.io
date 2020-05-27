<?
session_start();

$_SESSION['login']=$_POST['login'];
$_SESSION['password']=md5($_POST['password']);
$_SESSION['product']=$_POST['product'];

header("Location: options.php");
?>