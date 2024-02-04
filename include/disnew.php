<SCRIPT language=JavaScript type=text/javascript>
function icon(text) {
	var txtarea = document.post.ftext;
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
	} else {
		txtarea.value  += text;
	}
	txtarea.focus();
}
</SCRIPT>

<SCRIPT language="JavaScript">
function confirmDelete(text,url)
{
	temp = window.confirm(text);
	if (temp) { //delete
		window.location=url;
	}
}
</SCRIPT>



<?
if (isset($login)){
include_once("include/check.php");
$out .="
<form name='post' action='index.php' method=post>
<TABLE border='1' width='100%' cellpadding='3' cellspacing='3' bgcolor='$main_color'>
<TR><TD>

<table width=100%>
<tr><td width=120><b>Комментарий:</b></td>
  <td>
  <TABLE cellpadding='0' cellspacing='0'>
    <TR>
      <TD><A href='javascript:icon(\"[p]\")'><IMG src='img/b_p.gif' width='23' height='22' border='0' alt='Новый параграф'></A></TD>
      <TD><A href='javascript:icon(\"[br]\")'><IMG src='img/b_br.gif' width='23' height='22' border='0' alt='Новая строка'></A></TD>
      <TD><A href='javascript:icon(\"&nbsp;&nbsp;&nbsp;\")'><IMG src='img/b_sp.gif' width='23' height='22' border='0' alt='Пробел'></A></TD>

      <TD><A href=#post onclick='TagsStyle(0);'><IMG src='img/b_b.gif' width='23' height='22' border='0' alt='Утолщенный шрифт'></A></TD>
      <TD><A href=#post onclick='TagsStyle(2);'><IMG src='img/b_i.gif' width='23' height='22' border='0' alt='Курсивный шрифт'></A></TD>
      <TD><A href=#post onclick='TagsStyle(4);'><IMG src='img/b_u.gif' width='23' height='22' border='0' alt='Подчеркнутость'></A></TD>
      <TD><A href=#post onclick='TagsStyle(8);'><IMG src='img/b_c.gif' width='23' height='22' border='0' alt='Выровнять по центру'></A></TD>
      <TD>&nbsp;<< Возможно применение стилей к выделенному фрагменту</TD>
    </TR>
  </TABLE>

  </td></tr>
<tr><td width=120>Тема:<br>Cообщениe:</td>
<td>
  <input type=text name=topic size='' maxsize='255' value='$topic' class=lf_input></td></tr>
<tr><td width=120>

<TABLE cellSpacing=0 cellPadding=2 width=100 border=0>
<TR vAlign=center align=middle>
	<TD><A href='javascript:icon(\"%20:sm1:%20\")'><IMG src='img/sm1.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm2:%20\")'><IMG src='img/sm2.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm3:%20\")'><IMG src='img/sm3.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm4:%20\")'><IMG src='img/sm4.gif' border=0></A></TD>
</TR><TR vAlign=center align=middle>
	<TD><A href='javascript:icon(\"%20:sm5:%20\")'><IMG src='img/sm5.gif' border=0></A></TD>
        <TD><A href='javascript:icon(\"%20:sm6:%20\")'><IMG src='img/sm6.gif' border=0></A></TD>
        <TD><A href='javascript:icon(\"%20:sm7:%20\")'><IMG src='img/sm7.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm8:%20\")'><IMG src='img/sm8.gif' border=0></A></TD>
</TR><TR vAlign=center align=middle>
	<TD><A href='javascript:icon(\"%20:sm9:%20\")'><IMG src='img/sm9.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm10:%20\")'><IMG src='img/sm10.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm11:%20\")'><IMG src='img/sm11.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm12:%20\")'><IMG src='img/sm12.gif' border=0></A></TD>
</TR><TR vAlign=center align=middle>
	<TD><A href='javascript:icon(\"%20:sm13:%20\")'><IMG src='img/sm13.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm14:%20\")'><IMG src='img/sm14.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm15:%20\")'><IMG src='img/sm15.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm16:%20\")'><IMG src='img/sm16.gif' border=0></A></TD>
</TR><TR vAlign=center align=middle>
	<TD><A href='javascript:icon(\"%20:sm17:%20\")'><IMG src='img/sm17.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm18:%20\")'><IMG src='img/sm18.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm19:%20\")'><IMG  src='img/sm19.gif' border=0></A></TD>
	<TD><A href='javascript:icon(\"%20:sm20:%20\")'><IMG src='img/sm20.gif' border=0></A></TD>
</TR></TABLE>

</td><td valign=top><textarea type=textarea name=ftext rows=7 class=lf_input ></textarea> </td></tr>
<tr><td>
<input type=hidden name='$var' value='$PID'>
<input type=hidden name='offset' value='$offset'>
<input type=hidden name=C value='$C'></td><td align='center'>


<input type=hidden name=newmess value='Отправить'>
<input type=image  border=0 src='img/send.gif' name=newmess value='Отправить'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='#post' onClick=\"document.post.newmess.value =''\";> <img src='img/clear.gif' border=0></a>
</td></tr>
</table>
</TD></TR>

</TABLE></form>";
}else{
$out .="<form action='index.php' method=post><TABLE border='1' width='100%' cellpadding='3' cellspacing='3' bgcolor='$main_color'>
<TR><TD><center>Для участия в дискуссии  необходимо авторизоваться на сайте.</center>
<HR>


Логин: <input type='text' name='user_login' size=6>
Пароль:<input name='user_pw' type='password' size=6>
<input type=hidden name=enter value='ok'>
<INPUT type='image' onClick='submit();' src='./img/ok.gif'>
";
	if (isset($PID)) $out .= "<input type=hidden name=PID value='$PID'>";
	if (isset($CID)) $out .= "<input type=hidden name=CID value='$CID'>";
	if (isset($FID)) $out .= "<input type=hidden name=FID value='$FID'>";
	if (isset($DID)) $out .= "<input type=hidden name=DID value='$DID'>";
$out .= "




</TD></TR>
        </TABLE></form>";
//$view = 0;
}
?>
