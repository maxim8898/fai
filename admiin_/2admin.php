<?php
error_reporting(0);
session_start();
$login = $_SESSION['login'];
$pass = $_SESSION['pass'];
$nick = $_SESSION['nick'];

//extract($_POST); extract($_GET);
extract($_GET); extract($_POST);

include_once("../config/connect.php"); include_once("../config/config.php");
//mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("������ ����������� � MySQL"); mysql_select_db(DB_NAME) or die("������ ����������� � ��");	
@mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("������ �������� ����������"); @mysql_query("SET NAMES 'cp1251'"); @mysql_select_db(DB_NAME) or die("������ �������� ����������");

include_once("../include/checkadmin.php");
?>
<html>
<head>

<link rel=STYLESHEET href="../templ/styles.css" type="text/css">
<META http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>

<body bgcolor=#EEEEEE>
<p style='margin-top:4.0pt'> </p>
<TABLE border="1" width="100%" cellpadding="2" cellspacing="3" bgcolor= <?php echo "$light_color"; ?>>
    <TR>
      <TD colspan="2" align="center" background="../img/but_f.gif"><font size=-1><b>����� ���������</b></font></TD>
    </TR>
    <TR>
      <TD valign="top" width="50%">

      <table cellpadding=5>
	  <tr>
            <td><a href="acateg.php?CID=1"><img src="../img/cat.gif" border=0></a></td>
            <td><a href="acateg.php?CID=1">������� � ���������</a></td>
          </tr>        
          <tr>
            <td><a href="admin.php?path=customers"><img src="../img/users.gif" border=0></a></td>
            <td><a href="admin.php?path=customers">������������</a></td>
          </tr>
	  <tr>
            <td><a href="anews.php"><img src="../img/new.gif" border=0></a></td>
            <td><a href="anews.php">������� (������)</a>
            </td>
          </tr>
        </table>
      </TD>
      <TD valign="top">
      <table cellpadding=5>
          <tr>
            <td align=center><a href="admin.php?path=settings"><img src="../img/edit.gif" border=0></a></td>
            <td><a href="admin.php?path=settings">���� ������������</a></td>
          </tr>
          <tr>
            <td><a href="admin.php?path=statistics"><img src="../img/stat.gif" border=0></a></td>
            <td><a href="admin.php?path=statistics">����������</a></td>
          </tr>
          <tr>
            <td><a href="admin.php?path=voting"><img src="../img/vote.gif" border=0></a></td>
            <td><a href="admin.php?path=voting">������ (�����������)</a></td>
          </tr>
        </table>
      </TD>
    </TR>
    <TR>
      <TD colspan="2" align="center" background="../img/but_f.gif"><font size=-1><b>��������� �������</font></b></TD>
    </TR>
    <TR>
      <TD valign="top">
<table cellpadding=5>
      <tr>
            <td><a href="aforum.php?CID=1"><img src="../img/extra.gif" border=0></a></td>
            <td><a href="aforum.php?CID=1">������� � ������</a></td>
          </tr>
	 <tr>
            <td align=center><img src="../img/paper.gif" border=0></td>
            <td><a class=standard href="admin.php?path=news"><u> <?php echo ADMIN_NEWS;?></u></a>
            </td>
          </tr>
        
      </table>
	</TD>
      <TD valign="top">
<table cellpadding=5>
        
          
          <tr>
            <td align=center><img src="../img/paper.gif" border=0></td>
            <td><a class=standard href="admin.php?path=ext&page=ext1"><u><?php echo ADMIN_ABOUT_PAGE;?></u></a>
            </td>
          </tr>
 <tr>
            <td align=center><img src="../img/paper.gif" border=0></td>
            <td><a class=standard href="admin.php?path=ext&page=ext2"><u><?php echo ADMIN_SHIPPING_PAGE;?></u></a>
            </td>
          </tr>
        </table>

      </TD>
    </TR>
    <TR><TD colspan="2" align="center" background="../img/but_f.gif"><font size=-1><b>��������� ����</font></b</TD></TR>
    <TR>
      <TD valign="top">��������� ��������� � ��������<BR>���������� � ������������</TD>
      <TD valign="top">��������� ��������� � ��������<BR>���������� � ������������</TD>
    </TR>
    <TR><TD colspan="2" align="center" background="../img/but_f.gif"><font size=-1><b>��������� ��������</font></b></TD></TR>
    <TR>
      <TD valign="top">
      <table cellpadding=5>
          <tr>
            <td><a href="admin.php?path=product_options"><img src="../img/extra.gif" border=0></a></td>
            <td><a href="admin.php?path=product_options">��������� � ������</a></td>
          </tr>
	  <tr>
            <td><a href="admin.php?path=new_orders"><img src="../img/new.gif" border=0></a></td>
            <td><a href="admin.php?path=new_orders">����� ������</a>
            </td>
          </tr>
        </table>
     </TD>
      <TD valign="top">
      <table cellpadding=5>
	  <tr>
            <td align=center><A href="admin.php?path=shipping_payment"><img src="../img/ship.gif" border=0></A></td>
            <td><a href="admin.php?path=shipping_payment">������� ��������</a></td>
          </tr>
          <tr>
            <td align=center><a href="admin.php?path=gateways"><img src="../img/payment.gif" border=0></a></td>
            <td><a href="admin.php?path=gateways">������� ������</a></td>
          </tr>
        </table>
      </TD>
    </TR>
    <TR><TD colspan="2" align="center" background="../img/but_f.gif"><font size=-1><b>����������������� ��</font></b></TD></TR><TR>
      <TD valign="top">
      <table cellpadding=5>
          <tr>
            <td><a href="admin.php?path=synchronize"><img src="../img/sync.gif" border=0></a></td>
            <td><a href="admin.php?path=synchronize">������������� ��</u></a></td>
          </tr>
        </table>
      </TD>
      <TD valign="top">��������� ��������� � ��������<BR>���������� � ������������</TD>
    </TR>

    <TR>
      <TD colspan="2"></TD>
    </TR>
    <TR>
      <TD valign="top"></TD>
      <TD valign="top"></TD>
    </TR>
</TABLE>
<center>
<a href="../index.php?CID=0">������� � �����</a>
</center>
</body>

</html>