<?

define("loginform",1); include_once("_fform.php");
$buf=loginform_show("fform/_remember.lf"); //ВНИМАНИЕ: ТУТ НУЖНО УКАЗАТЬ ИМЯ ФОРМЫ

if (isset($onSubmit)){
  $res=mysql_query("SELECT login, email FROM ok_users WHERE email='$form[email]'");
  $Row=mysql_fetch_array($res);
  if ($Row[0] == $form[login] && $Row[1]==$form[email]) {
	$ok=1;
  }else{
	exit(header("Location: index.php?error=2"));
  }
}

if (isset($onSubmit) && !isset($error) && $ok){
	$buf = "<center>Операция выполнена!</center><br><p> На Ваш E-Mail высланы данные, необходимые для авторитизации на сайте. Повторное восстановление пароля возможно не ренее чем через 1 час.</p>";
	$pass = ''; for ($i=0; $i<6; $i++)  $pass .= rand(0,9);
	$md5_pass = MD5($pass);
	$datereg=time();
	mysql_query("UPDATE ok_users SET pass='$md5_pass' WHERE login ='$form[login]'");
	$mail = "Здравствуйте.\n\n\nВы зпросили восстановление забытого пароля на сайте \"$sitename\".\n\n";
	$mail.= "В целях безопасности системой был сгенерирован новый пароль. В дальнейшем Вы его сможете изменить.\n\n";
	$mail.= "Ваши авторизационные данные:\n\n";
        $mail.= "Логин : $form[login]\n";
	$mail.= "Пароль: $pass\n";
	$mail.= "\n\n\nЭто сообщение создано почтовым роботом. Пожалуйста, не отвечайте на это письмо c помощью функции \"ОТВЕТИТЬ\"";
        $mail.= "\n$email";
	mail($form[email], "Восстановление пароля на сайте \"$sitename\"", "$mail", "From: \"$sitename\"<$email>;\nContent-Type: text/plain; charset=\"windows-1251\"\nReturn-path: <$email>");
}
?>
