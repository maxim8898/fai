<?
error_reporting(0);
session_start();
$login = $_SESSION['login'];
$pass = $_SESSION['pass'];
$nick = $_SESSION['nick'];

extract($_POST); extract($_GET);

include_once("../config/connect.php"); include_once("../config/config.php");
//mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("Ошибка подключения к MySQL"); mysql_select_db(DB_NAME) or die("Ошибка подключения к БД");
@mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("Сервис временно недоступен"); @mysql_query("SET NAMES 'cp1251'"); @mysql_select_db(DB_NAME) or die("Сервис временно недоступен");
include_once("../include/checkadmin.php");


if (isset($visible)){
  $result = MYSQL_QUERY("UPDATE ok_products SET visible='$visible' WHERE PID='$PID'");
}
if (isset($Cedit)){
  if (isset($del)){
   mysql_query("DELETE FROM ok_categories WHERE CID ='$CID'");
   exit(header("Location: acateg.php"));
  }else{
    if (isset($New)){
        $time = time();
	mysql_query("INSERT INTO ok_categories (parent, tip, col, visible, discussion, showrating, sort, date) VALUES ('$CID', 1, 1, 1, 1, 1, 1, $time)");
	$CID = mysql_insert_id();
    }
    include_once("../fform/fcateg.php");
    ?>
	<TABLE border="1" width="100%" cellpadding="2" cellspacing="3" bgcolor="#dee7ef">
	    <TR><TD height="23" background="../img/but_f.gif" align="center"><FONT size="-1">Редактирование разделов и категорий</FONT></TD></TR>
	    <TR><TD align="left"><? echo $buf; ?></TD></TR>
	</TABLE>
    <?
  }
} else if (isset($Pedit)){
  if (isset($del)){
   mysql_query("DELETE FROM ok_products WHERE PID ='$PID'");
   exit(header("Location: acateg.php?CID=$CID"));
  }else{
    if (isset($New)){
        $time = time();
	mysql_query("INSERT INTO ok_products (CID, visible, date) VALUES ('$CID', 1, '$time')");
	$PID = mysql_insert_id();
    }
    include_once("../fform/fprod.php");
    ?>
	<TABLE border="1" width="100%" cellpadding="2" cellspacing="3" bgcolor="#dee7ef">
	    <TR><TD height="23" background="../img/but_f.gif" align="center"><FONT size="-1">Редактирование продукта/материала/статьи/</FONT></TD></TR>
	    <TR><TD align="left"><? echo $buf; ?></TD></TR>
	</TABLE>
    <?
  }

}else {


$out='<table bgcolor=white border=0 cellpadding=3 cellspacing=0 width=100%>'; $out1='';
if (!isset($CID)){
	$CID=0; $parent = 0;
}else{
	$r=mysql_query("SELECT parent, name, tip FROM ok_categories WHERE CID='$CID'");
	$Row=mysql_fetch_row($r); $parent = $Row[0];
}

$r=mysql_query("SELECT tip, parent, pnum, CID, name, sort FROM ok_categories WHERE tip<>3 and (parent='$CID' or parent= '$parent' or parent=0) order by parent, pnum");
$out .="<tr bgcolor=$middle_color><td class=lf_tr></td><td class=lf_tr align=center><b>Список категорий</b></td><td class=lf_tr></td></tr>";
while($Row=mysql_fetch_assoc($r)) {
  $out .= "<tr><td class=lf_tr width=16><a href = acateg.php?CID=$Row[CID]&Cedit=1><img src='../img/b_edit.png' alt='Изменить' border=0></a></td><td class=lf_tr>";
  if ($CID == $Row[CID]){
	$out .="<img src='../img/cur.gif' width='14' height='13'><a href=acateg.php?CID=$Row[CID]> $Row[name]</a>";
	if ($Row[sort] == 1) $order="ORDER by date"; else if ($Row[sort] == 2) $order="ORDER by rating DESC"; else if ($Row[sort] == 4) $order="ORDER by name";else $order="ORDER by pnum";
  }else if ($Row[parent] == 0){
	$out .="<img src='../img/cur1.gif' width='8' height='9'><a href=acateg.php?CID=$Row[CID]> $Row[name]</a>";
  }else { //if ($Row[parent]==$parent){
	$out .="&nbsp;&nbsp;<img src='../img/cur2.gif' width='8' height='9'><a href=acateg.php?CID=$Row[CID]> $Row[name]</a>";
  }
  $out .= "</td><td class=lf_tr width=16><a href=\"javascript:confirmDelete('Удалить категорию?','acateg.php?CID=$Row[CID]&Cedit=1&del=1');\"><img src='../img/b_drop.png' alt='Удалить' border=0></a></td></tr>";
}
$out .="</table>";
$out .= "<br><center><a href = acateg.php?New=1&Cedit=1>Добавить категорию</a></center>";


$r=mysql_query("SELECT PID, CID, name, visible, pnum, price FROM ok_products where CID='$CID' $order");
$count = mysql_num_rows($r);
if ($count>0){
	$out1 .="<table border=0 cellpadding=3 cellspacing=0 width=100% bgcolor=eaeaea>";
	$out1 .="<tr bgcolor=$middle_color><td class=lf_tr></td><td class=lf_tr></td><td class=lf_tr align=center><b>Содержание раздела</b></td><td class=lf_tr>№</td><td class=lf_tr>Цена</td><td class=lf_tr align=center>img</td><td class=lf_tr align=center>ico</td><td class=lf_tr></td></tr>";
	while($Row=mysql_fetch_array($r)) {

		$icon="../pictures/i_$Row[PID].gif";
		if (file_exists($icon)) $icon="+"; else  $icon="-";

		$picture="../pictures/p_$Row[PID].gif";
		if (file_exists($picture)) $img="+";else  $img="-";

		$newvisible = $Row[visible]+1; if($newvisible >1) $newvisible = 0; else $newvisible=1;
		$out1 .="<tr>
		<td class=lf_tr width=12><INPUT type='checkbox' name='chvisible' "; if ($Row[visible]) $out1.=" checked title='Видимый'"; $out1 .=" title='Не видимый' onclick=\"JumpURL('acateg?CID=$CID&PID=$Row[PID]&visible=$newvisible');\"></td>
		<td class=lf_tr width=16><a href = acateg.php?CID=$Row[CID]&PID=$Row[PID]&Pedit=1><img src='../img/b_edit.png' alt='Изменить' border=0></a></td>
		<td class=lf_tr>$Row[name]</td>
		<td class=lf_tr>$Row[pnum]</td>
		<td class=lf_tr>$Row[price]</td>
		<td class=lf_tr align=center>$img</td>
		<td class=lf_tr align=center>$icon</td>
		<td class=lf_tr width=16><a href=\"javascript:confirmDelete('Удалить содержимое?','acateg.php?PID=$Row[PID]&Pedit=1&del=1&CID=$CID');\"><img src='../img/b_drop.png' alt='Удалить' border=0></a></td></tr>";
	}
	$out1 .="</table>";
}else{
  $out1="В данной категории материалов нет.";
}
$out1 .= "<br><center><a href = acateg.php?New=1&Pedit=1&CID=$CID>Добавить материал</a></center>";
$out1 = mb_convert_encoding($out1, "utf-8", "windows-1251");


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
      <TD colspan="2" align="center" background="../img/but_f.gif">Настройка разделов и категорий ...</TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
	<? echo "$out"; ?>
      </TD>
      <TD valign="top">
	<? echo "$out1"; ?>
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
