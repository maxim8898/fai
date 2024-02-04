<?
session_start();
error_reporting(0);
$login = $_SESSION['login'];
$pass = $_SESSION['pass'];
$nick = $_SESSION['nick'];

extract($_POST); extract($_GET);

include_once("../config/connect.php"); include_once("../config/config.php");
//mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("Ошибка подключения к MySQL"); mysql_select_db(DB_NAME) or die("Ошибка подключения к БД");
@mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("Сервис временно недоступен"); @mysql_query("SET NAMES 'cp1251'"); @mysql_select_db(DB_NAME) or die("Сервис временно недоступен");
include_once("../include/checkadmin.php");

if (isset($visible)){
  $result = MYSQL_QUERY("UPDATE ok_news SET visible='$visible' WHERE NID='$NID'");
}
if (isset($Nedit)){
  if (isset($del)){
   mysql_query("DELETE FROM ok_news WHERE NID ='$NID'");
   exit(header("Location: anews.php"));
  }else{
    if (isset($New)){
        $time = time();
	mysql_query("INSERT INTO ok_news (visible, date) VALUES (1, $time)");
	$NID = mysql_insert_id();
    }
    include_once("../fform/fnews.php");
    ?>
	<TABLE border="1" width="100%" cellpadding="2" cellspacing="3" bgcolor="#dee7ef">
	    <TR><TD height="23" background="../img/but_f.gif" align="center"><FONT size="-1">Редактирование новостей (анонсов)</FONT></TD></TR>
	    <TR><TD align="left"><? echo $buf; ?></TD></TR>
	</TABLE>
    <?
  }
}else {


if ($ordernews ==1) $order ="order by pnum"; else $order = "order by date DESC";
$r=mysql_query("SELECT * FROM ok_news $order");

$out='<table bgcolor=white border=0 cellpadding=3 cellspacing=0 width=100%>'; $out1='';
$out .="<tr bgcolor=$middle_color><td class=lf_tr></td><td class=lf_tr></td><td class=lf_tr>№</td><td class=lf_tr>Дата</td><td class=lf_tr align=center><b>Содержание</b></td><td class=lf_tr>PID</td><td class=lf_tr>img</td><td class=lf_tr></td></tr>";
while($Row=mysql_fetch_assoc($r)) {
  $icon="../pictures/n_$Row[NID].gif";	if (file_exists($icon)) $icon="+"; else  $icon="-";

  $newvisible = $Row[visible]+1; if($newvisible >1) $newvisible = 0; else $newvisible=1;
  $date=date("d.m.Y", $Row[date]);
  $out .="<tr>
  <td class=lf_tr width=12><INPUT type='checkbox' name='chvisible' "; if ($Row[visible]) $out.=" checked title='Видимый'"; $out .=" title='Не видимый' onclick=\"JumpURL('anews.php?NID=$Row[NID]&visible=$newvisible');\"></td>
  <td class=lf_tr width=16><a href=anews.php?NID=$Row[NID]&Nedit=1><img src='../img/b_edit.png' alt='Изменить' border=0></a></td>
  <td class=lf_tr>$Row[pnum]</td>
  <td class=lf_tr>$date</td>
  <td class=lf_tr>$Row[body]</td>
<td class=lf_tr>$Row[PID]</td>
<td class=lf_tr align=center>$icon</td>
  <td class=lf_tr width=16><a href=\"javascript:confirmDelete('Удалить новость?','anews.php?NID=$Row[NID]&Nedit=1&del=1');\"><img src='../img/b_drop.png' alt='Удалить' border=0></a></td>
  </tr>";
}
$out .="</table>";
$out .= "<br><center><a href = anews.php?New=1&Nedit=1>Добавить новость</a></center>";

$out = mb_convert_encoding($out, "utf-8", "windows-1251");


?>
<html>
<head>

<link rel=STYLESHEET href="../templ/styles.css" type="text/css">
<META http-equiv="Content-Type" content="text/html; charset=windows-1251">
<SCRIPT language="JavaScript">
function JumpURL(url)
{
  if (url != '')
  {
    window.location = url;
  }
}
function confirmDelete(text,url)
{
	temp = window.confirm(text);
	if (temp) { //delete
		window.location=url;
	}
}
</SCRIPT>

</head>

<body bgcolor=#eaeaea>
<p style='margin-top:4.0pt'> </p>
<TABLE border="1" width="100%" cellpadding="2" cellspacing="3" bgcolor= <? echo "$light_color"; ?>>
    <TR>
      <TD align="center" background="../img/but_f.gif">Настройка новостей (анонсов)</TD>
    </TR>
    <TR>
      <TD valign="top">
	<? echo "$out"; ?>
      </TD>
    </TR>
</TABLE>
<center>
<a href="admin.php">Меню администратора</a>
<a href="../index.php?CID=<? echo $CID;?>">Переход к сайту</a>
</center>
</body>

</html>
<?
}
?>
