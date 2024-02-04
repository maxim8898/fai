<?php
error_reporting(0);
session_start();
$login = $_SESSION['login'];
$pass = $_SESSION['pass'];
$nick = $_SESSION['nick'];

extract($_POST); extract($_GET);

include_once("../config/connect.php"); include_once("../config/config.php");
//mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("������ ����������� � MySQL"); mysql_select_db(DB_NAME) or die("������ ����������� � ��");	
@mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("������ �������� ����������"); @mysql_query("SET NAMES 'cp1251'"); @mysql_select_db(DB_NAME) or die("������ �������� ����������");
include_once("../include/checkadmin.php");

if (isset($visible)){
  $result = MYSQL_QUERY("UPDATE ok_categories SET visible='$visible' WHERE CID='$CID'");
}
if (isset($Cedit)){
  if (isset($del)){
   mysql_query("DELETE FROM ok_categories WHERE CID ='$CID'"); 
   exit(header("Location: aforum.php?C=$C"));
  }else{
    if (isset($New)){
	if (!isset($C)) $C=0;
	mysql_query("INSERT INTO ok_categories (parent, tip, visible, discussion) VALUES ($C, 3, 1, 1)");
	$CID = mysql_insert_id();
    }
    if ($Cedit==1) include_once("../fform/frazdel.php"); else include_once("../fform/fforum.php");
    ?>
	<TABLE border="1" width="100%" cellpadding="2" cellspacing="3" bgcolor="#dee7ef">
	    <TR><TD height="23" background="../img/but_f.gif" align="center"><FONT size="-1">�������������� �������� � ���������</FONT></TD></TR>
	    <TR><TD align="left"><?php echo $buf; ?></TD></TR>
	</TABLE>
    <?php
  }


}else {


$out='<table bgcolor=white border=0 cellpadding=3 cellspacing=0 width=100%>'; $out1='';

$r=mysql_query("SELECT tip, CID, name FROM ok_categories WHERE parent=0 and tip=3");
$out .="<tr bgcolor=$middle_color><td class=lf_tr></td><td class=lf_tr align=center><b>�������</b></td><td class=lf_tr></td></tr>";
while($Row=mysql_fetch_assoc($r)) {
  $out .= "<tr><td class=lf_tr width=16><a href = aforum.php?CID=$Row[CID]&Cedit=1><img src='../img/b_edit.png' alt='��������' border=0></a></td><td class=lf_tr>";
  if ($C == $Row[CID]){
	$out .="<img src='../img/cur.gif' width='14' height='13'><a href=aforum.php?C=$Row[CID]> $Row[name]</a>";
  }else{
	$out .="<img src='../img/cur1.gif' width='8' height='9'><a href=aforum.php?C=$Row[CID]> $Row[name]</a>";
  }
  $out .= "</td><td class=lf_tr width=16><a href=\"javascript:confirmDelete('������� ���������?','aforum.php?CID=$Row[CID]&Cedit=1&del=1');\"><img src='../img/b_drop.png' alt='�������' border=0></a></td></tr>";
}
$out .="</table>";
$out .= "<br><center><a href = aforum.php?New=1&Cedit=1>�������� ������</a></center>";


$r=mysql_query("SELECT CID, name, visible, parent FROM ok_categories where parent='$C' and tip=3 and parent <> 0");
$count = mysql_num_rows($r);
if ($count>0){
	$out1 .="<table border=0 cellpadding=3 cellspacing=0 width=100% bgcolor=eaeaea>"; 
	$out1 .="<tr bgcolor=$middle_color><td class=lf_tr></td><td class=lf_tr></td><td class=lf_tr align=center><b>������ �������</b></td><td class=lf_tr></td></tr>";
	while($Row=mysql_fetch_array($r)) {
		$newvisible = $Row[visible]+1; if($newvisible >1) $newvisible = 0; else $newvisible=1;
		$out1 .="<tr>
		<td class=lf_tr width=12><INPUT type='checkbox' name='chvisible'"; if ($Row[visible]) $out1.=" checked title='�������'"; else $out1 .=" title='�� �������'"; $out1.=" onclick=\"JumpURL('aforum?CID=$Row[CID]&C=$C&visible=$newvisible');\"></td>
		<td class=lf_tr width=16><a href = aforum.php?CID=$Row[CID]&Cedit=2><img src='../img/b_edit.png' alt='��������' border=0></a></td>
		<td class=lf_tr>$Row[name]</td>
		<td class=lf_tr width=16><a href=\"javascript:confirmDelete('������� �����?','aforum.php?CID=$Row[CID]&Cedit=1&del=1&C=$C');\"><img src='../img/b_drop.png' alt='�������' border=0></a></td></tr>";
	}
	$out1 .="</table>";
}else{
  $out1="� ������ ������� ������� ���.";
}
$out1 .= "<br><center><a href = aforum.php?New=1&Cedit=2&C=$C>�������� �����</a></center>";

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
<TABLE border="1" width="100%" cellpadding="2" cellspacing="3" bgcolor= <?php echo "$light_color"; ?>>
    <TR>
      <TD colspan="2" align="center" background="../img/but_f.gif">��������� �������� � ��� ������� ...</TD>
    </TR>
    <TR>
      <TD valign="top" width="30%">
	<?php echo "$out"; ?>
      </TD>
      <TD valign="top">
	<?php echo "$out1"; ?>
      </TD> 
    </TR>
</TABLE>
<center>
<a href="admin.php">���� ��������������</a>
<a href="../index.php?CID=<?php echo $CID;?>">������� � �����</a>
</center>
</body>

</html>
<?php
}
?>