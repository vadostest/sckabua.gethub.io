<? 
session_start();
include ("logins.php");
if (($_SESSION['login']==$login) AND ($_SESSION['password'])==$password) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="http://it-senior.pp.ua" />
    <meta name="copyright" content="Meridian Promotion Group" />
<title>Configuration for LandingPage <?= $_SERVER['SERVER_NAME'] ?></title>
    <meta name="keywords" content="Ключевые слова">
    <meta name="description" content="Описание">

<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/png">
       
    <style>
	body {
  font-family:Arial, Helvetica, sans-serif;
  max-width: auto;
 text-align: center;
 
}
.form h2 {

  margin-bottom: 20px;
}

.form{
width: 900px;

 margin: <? if ($_POST['product']=="password") echo "100px"; else echo("0"); ?> auto auto auto;
}

.form p {
  margin-top: 0px;
}

.form fieldset {
  margin-bottom: 15px;
  padding: 10px;
  border: solid;
}

.form legend {
  padding: 0px 3px;
  font-weight: bold;
  font-variant: small-caps;
}

.form label {
  width: 210px;
  display: inline-block;
  vertical-align: top;
  margin: 6px;
}
.form label span{
	font-size: 10px;
	color: darkgray;
}

.form em {
  font-weight: bold;
  font-style: normal;
  color: #f00;
}
.form input:focus {
  background: #eaeaea;
}

.form input, textarea {
  width: 549px;
}

.form textarea {
  height: 100px;
}

.form select {
  width: 254px;
}

.form input[type=checkbox] {
  width: 10px;
}

.form input[type=submit] {
  width: 170px;
  padding: 10px;

}
.ok
{
	color: red;
}
.exit{
	position: fixed;
	top: 20px;
	right: 50px;
}
	</style>

  </head>
  <body>
  <div class="exit"><a href="exit.php" title="Выйти из конфигуратора.">&#10008; Выйти</a></div>
 <? $include=$_SESSION['product'].".php";
 $save=$_SESSION['product']."_save.php";
if ($_POST['product']=="password") $th1="Настройки доступа для"; else $th1="Основные настройки для";
 ?>
  <h1><?= $th1." ".$_SERVER['SERVER_NAME'] ?></h1>
 
    <form class="form" action="<?= $save ?>" method="POST">
 <? if ($_GET['save']=='1') echo ('<div class="ok">Данные успешно сохранены!</div>');
include("{$include}") ?>
<p><input type="submit" value="Сохранить"></p><br>
</form>

      </body>
</html>
<? }
else
header("Location: index.php?pass=1"); ?>