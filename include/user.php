<?php
//Форма авторизации на сайте
if (!isset($login)) {
$out_usr = "
<table border=0 width=100%>
<form action='index.php' method=post>
<tr>
	<td align=left>Логин: </td>
	<td><input type='text' name='user_login' size=6></td>
        <td align=right>&nbsp;</td>
</tr><tr>
	<td align=left>Пароль: </td>
	<td><input name='user_pw' type='password' size=6></td>
        <td align=right><input type=hidden name=enter value='ok'><INPUT type='image' onClick='submit();' src='./img/ok.gif'></td>
</tr>

<tr>
	<td colspan=3><INPUT type='checkbox' name='save'> Запомнить меня</td>
</tr>
	";
	if (isset($PID)) $out_usr .= "<input type=hidden name=PID value='$PID'>";
	if (isset($CID)) $out_usr .= "<input type=hidden name=CID value='$CID'>";
	if (isset($FID)) $out_usr .= "<input type=hidden name=FID value='$FID'>";
	if (isset($DID)) $out_usr .= "<input type=hidden name=DID value='$DID'>";
	$out_usr .= "
</tr><tr>
	<td colspan=2><font size=2><a href='index.php?act=freg'>Регистрация</a></font></td>
        <td align=right><font size=2><a href='index.php?act=forgot'>забыли?</a></font></td>
</tr>
</form>
</table>
	";

} else {
  $out_usr = "
  <table>
  <tr><td>Пользователь: <b>$nick</b></td></tr>
  ";
  if (isset($login) && $level > 70) {
	$out_usr .= "<tr><td><a href='./admiin/admin.php' target=main><font color=red>АДМИНИСТРИРОВАНИЕ</font></a></td></tr>
	";
  }
  $out_usr .= "<tr><td><a href='index.php?act=fuser'>Изменить анкету</a></td></tr>
  <tr><td><a href='index.php?logout=yes'>Завершить сеанс</a></td></tr>
  </table>
  ";
}
?>
