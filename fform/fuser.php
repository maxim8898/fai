<?
if (isset($Cancel)){
  exit(header("Location: index.php"));
}

$login = $_SESSION['login'];
$nick = $_SESSION['nick'];
$mynick = $nick;
	
if (!isset($form)){  // Первоначальные данные
	// $login = $_SESSION['login'];
	// $nick = $_SESSION['nick'];
	// $mynick = $nick;
	$res=mysql_query("SELECT * FROM ok_users WHERE login='$login'");
	$form=mysql_fetch_assoc($res);
}
$image1="./pictures/$login"."_f.gif";
if (file_exists($image1))
	$form[image1]="<img src=$image1 width=128>";
else  $form[image1]="ИЗОБРАЖЕНИЕ НЕ ЗАГРУЖЕНО";

if (isset($onSubmit)) {
	$form[nick] = strtr($form[nick], "ЕТОРАНКХСВМеуоракхс", "ETOPAHKXCBMeyopakxc"); 
	if (eregi("[^а-яА-Я0-9a-z_]",$form[nick])) $error[nick][] = "Недопустимые символы в поле НИК !";

	if ($form[nick]<> $mynick) {
		$res=mysql_query("SELECT nick FROM ok_users WHERE nick='".addslashes($form[nick])."'");
		$Row=mysql_fetch_array($res);
		if (count($Row)>1 && $form[nick] <> $mynick) $error[nick][]="К сожалению, выбранный НИК уже занят";
	}
}

//------------------------------------------
if ($form[upload]<>''){
$size= filesize($form[upload]);
copy($form[upload], "./pictures/$login"."_f.gif");

}
//------------------------------------------


define("loginform",1); include_once("_fform.php");
$buf=loginform_show("./fform/_user.lf"); //ВНИМАНИЕ: ТУТ НУЖНО УКАЗАТЬ ИМЯ ФОРМЫ

if (isset($onSubmit) && !isset($error)){
	$form[email] = strtolower($form[email]);
	$datereg=time();

	$query ="UPDATE ok_users
	SET 	login='$login',
		nick='$form[nick]',
		pol='$form[pol]',
		email='$form[email]',
		hideemail='$form[hideemail]', 
		fam='$form[fam]', 
		name='$form[name]', 
		ot='$form[ot]', 
		adres='$form[adres]', 
		subscribe='$form[subscribe]', 
		phone='$form[phone]'
	WHERE login='$login'";
	$result = MYSQL_QUERY($query); 
	$nick=$form[nick] ;$_SESSION['nick']=$nick;
	if ($form[newpass] <> '' ){
		$pass= MD5($form[newpass]);
		$_SESSION['pass']=$pass;
		MYSQL_QUERY("UPDATE ok_users SET pass='$pass' WHERE login='$login'");

		$mail = "Здравствуйте, $form[nick].\n\n\nВы изменили свою анкету на сайте \"$sitename\".\n\n";
		$mail.= "Ваши авторизационные данные:\n\n";
	        $mail.= "Логин : $login\n";
		$mail.= "Пароль: $form[newpass]\n";

		$mail.= "\n\n\nЭто сообщение создано почтовым роботом. Пожалуйста, не отвечайте на это письмо c помощью  функции \"ОТВЕТИТЬ\"";
	        $mail.= "\n$email";
//		mail($form[email], "Изменение анкеты на сайте \"$sitename\"", "$mail", "From: \"$sitename\"<$email>;\nContent-Type: text/plain; charset=\"windows-1251\"\nReturn-path: <$email>");
	}
header("Location: index.php");
}
?>