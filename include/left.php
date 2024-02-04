<?

if (isset($logout)){ //завершение сеанса
	$login='';$pass='';
	session_unregister("login"); session_unregister("pass"); session_unregister("nick");
	SetCookie("login",$login , 0); SetCookie("pass",$pass , 0);
	unset($login); unset($pass); unset($nick);
}else if (isset($enter) && !isset($login)){ // авторизация
        $user_login = htmlspecialchars(trim($user_login), ENT_QUOTES);
	$q = mysql_query("SELECT pass, nick FROM ok_users WHERE login='$user_login'");
	$row = mysql_fetch_array($q);
	if (($row) && $row[pass] == MD5($user_pw)){ // проверка пользователя по БД
		$login = $user_login; $pass = $row[pass]; $nick = $row[nick];
		session_register("login", "pass", "nick");
		if (isset($save)){SetCookie("login", $login, time()+33600); SetCookie("pass", $pass, time()+33600);}

		// обновление данных пользователя
	//	mysql_query("UPDATE ok_users SET default_currency=$current_currency WHERE Login='$login'") or die (mysql_error());

		//is it admin?
		if (!isset($order))
			if (!strcmp($login,ADMIN_LOGIN))
		;// ok			header("Location: admin.php");
			else{
				$z = "";
				if (isset($PID)) $z="?PID=$PID";
				else if (isset($CID)) $z="?CID=$CID";
			}

	}
	else // Ошибочный логин
		$wrongLoginOrPw = 1;

}
	include_once("user.php");
	$output = str_replace("{USER}", $out_usr, $output);

	include_once("categories.php");
	$output = str_replace("{CATEGORIES}", $out, $output);

	include_once("search.php");
	$output = str_replace("{SEARCH}", $out, $output);

	include_once("minichat.php");
	$output = str_replace("{MINICHAT}", $out, $output);

?>