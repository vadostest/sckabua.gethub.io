<? include ("logins.php");  ?>
<fieldset>
    <legend><h2>Доступ к конфигуратору: </h2></legend>
	 <label for="login">Логин: <em>*</em></label><input required id="login" type="text" name="login" value="<?=  $login ?>"></p>
	 <label for="password_old">Старый пароль: <em>*</em></label><input required id="password_old" type="text" name="password_old" placeholder="Ваш старый пароль" >
	 <label for="password">Пароль: <em>*</em></label><input required id="password" type="text" name="password" placeholder="Новый пароль доступа к конфигуратору" >
  </fieldset>
  
