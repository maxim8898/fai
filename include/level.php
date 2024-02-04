<?php
// Модуль проверки статуса пользователя

$level=1;
if(isset($login)){
	$login = htmlspecialchars(trim($login), ENT_QUOTES);
	$res=mysql_query("SELECT pass, level FROM ok_users WHERE login='$login'");
        $Row=mysql_fetch_assoc($res);
	if ($pass <> $Row[pass] || $Row[pass]=="" ) {
		exit(header("Location: ./index.php?error=1"));
	}
	$level = $Row[level];
}
?>
