<?
// Модуль проверки и безопасности
unset($error);

$a = strpos($HTTP_REFERER, $mainurl);
//echo "a=$a";

if ($a ===false || $a >11) {
	$url = $REQUEST_URI;
	$mail = "Попытка взлома на сайте \"$sitename\"\n\n";
	$mail.= "REFFERER=$HTTP_REFERER\nURL: $HTTP_HOST\nIP : $REMOTE_ADDR";
//	mail($email, "Попытка взлома на сайте \"$sitename\"", "$mail", "From: \"$sitename\"<$email>;\nContent-Type: text/plain; charset=\"windows-1251\"\nReturn-path: <$email>");
//	exit(header("Location: ./index.php?error=1"));
}
if(isset($login)){
	$login = htmlspecialchars(trim($login), ENT_QUOTES);
	$res=mysql_query("SELECT pass, nick FROM ok_users WHERE login='$login'");
        $Row=mysql_fetch_assoc($res);
	if ($pass <> $Row[pass] || $Row[pass]=="" || $pass == "") {
		exit(header("Location: ./index.php?error=1"));
	}
//echo "login= $login pass=$pass";
	$mynick = $Row[nick]; $nick = $Row[nick];
}
?>