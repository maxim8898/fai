<?
error_reporting(0);
session_start();
$ip = getRealIpAddr(); session_register("ip");

if ( isset($form[cod]) && $_SESSION[cod] <> md5($form[cod])){
  $error[cod][] = 'Ошибочный код подтверждения';
}

if (isset($onSubmit)) {
	if (eregi("[^а-яА-Я0-9a-z_]",$form[nick])) $error[nick][] = "Недопустимые символы в поле ЛОГИН !";
	$form[nick] = strtr($form[nick], "ЕТОРАНКХСВМеуоракхс", "ETOPAHKXCBMeyopakxc");
	if (eregi("[^а-яА-Я0-9a-z_]",$form[nick])) $error[nick][] = "Недопустимые символы в поле НИК !";
	$form[email] = strtolower($form[email]);

	if ($form[login]) {
	$res=mysql_query("SELECT login FROM ok_users WHERE login='$form[login]'");
	$Row=mysql_fetch_array($res);
	if (count($Row)>1) $error[login][]="К сожалению, выбранный логин уже занят";
	}
	if ($form[nick]) {
	$res=mysql_query("SELECT nick FROM ok_users WHERE nick='$form[nick]'");
	$Row=mysql_fetch_array($res);
	if (count($Row)>1) $error[nick][]="К сожалению, выбранный НИК уже занят";
	}
	if ($form[email]) {
	$res=mysql_query("SELECT email FROM ok_users WHERE email='".addslashes($form[email])."'");
	$Row=mysql_fetch_array($res);
	if (count($Row)>1) $error[email][]="Пользователь с таким E-Mail уже зарегистрирован";
	}
}

define("loginform",1); include_once("_fform.php");
$buf=loginform_show("fform/_reg.lf"); //ВНИМАНИЕ: ТУТ НУЖНО УКАЗАТЬ ИМЯ ФОРМЫ

if (isset($onSubmit) && !isset($error)){
	$buf = "<center>Регистрация прошла успешно!</center><br><p> На указанный Вами E-Mail выслано подтверждение о регистрации на сайте. Вы должны активировать свой аккаунт (авторизоваться на сайте с указанными данными Логин/Пароль) не позднее 24 часов с момента первичной регистрации.</p>
	<p>В дальнейшем регистрационные данные и пароль Вы можете изменить воспользовавшись ссылкой \"Изменить анкету\".";

	$pass = $form[pass];
//	$pass = ''; for ($i=0; $i<6; $i++)  $pass .= rand(0,9);
	$md5_pass = MD5($pass);

	$form[email] = strtolower($form[email]);
	$datereg=time();
         $ip = getRealIpAddr();

	$query = "INSERT INTO ok_users
	SET 	login='$form[login]',
		pass='$md5_pass',
		nick='$form[nick]',
		email='$form[email]',
		pol='$form[pol]',
		hideemail='$form[hideemail]',
	        datereg='$datereg',
		ip='$ip'";
	$result = MYSQL_QUERY($query);
	$mail = "Здравствуйте.\n\n\nВы зарегистрировались на сайте \"$sitename\".\n\n";
	$mail.= "Ваши авторизационные данные:\n\n";
        $mail.= "Логин : $form[login]\n";
	$mail.= "Пароль: $pass\n";
	$mail.= "\nВы должны активировать свой аккаунт (авторизоваться на сайте с указанными данными Логин/Пароль) не позднее 24 часов с момента первичной регистрации.";
	$mail.= "\n\n\nЭто сообщение создано почтовым роботом. Пожалуйста, не отвечайте на это письмо c помощью функции \"ОТВЕТИТЬ\"";
        $mail.= "\n$email";
	mail($form[email], "Регистрация на сайте \"$sitename\"", "$mail", "From: \"$sitename\"<$email>;\nContent-Type: text/plain; charset=\"windows-1251\"\nReturn-path: <$email>");
}
?>
