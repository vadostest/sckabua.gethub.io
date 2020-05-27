<?
session_start();

$_SESSION['login']="";
$_SESSION['password']="";
$_SESSION['product']="";

header("Location: index.php");
?>