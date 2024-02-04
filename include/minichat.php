<?
$out = ""; $f='';
$fn = 'minichat.txt';
if (file_exists($fn)){
  $f = file($fn);
}

//if ($txt !='' && isset($sendchat)){   // что-то отправлено
if ($txt !='' && isset($login)){   // что-то отправлено
  $txt = htmlspecialchars($txt);
  $time = date("d.m.y H:i", time()-$localtime * 3600);
  $txt = "<i>$time</i> <b> $nick</b><br> "."$txt"; 
  $ffile = fopen($fn, 'w+');
  fputs($ffile, "$txt\n");
  for ($i = 0; $i < count($f) && $i < 5; $i++) {
      fputs($ffile, "$f[$i]");
  }
 // $txt1=$txt; 
 // unset($txt);
  fclose($ffile);
}

// Вывод сообщений чата
$out .= "<font size=-2>"; if ($txt !=''){$out .="<TABLE width=100% style='Font-Size: 12px;'><TR><TD bgcolor='ffffff'>$txt</td></tr></table>"; $txt='';}
for ($i = 0; $i < count($f); $i++) {
	$out .="<TABLE width=100% style='Font-Size: 12px;'><TR><TD bgcolor='$light_color'>$f[$i]</TD></TR></TABLE>";
}
$out .= "</font>";


$out .="
<FORM>
<form action='index.php' name='formchat' method=post>
<input type='text' style='width:100%' maxlength='512' name='txt'"; if (!isset($login)) $out .="value='Нет авторизации'"; $out .=">
";
	if (isset($PID)) $out .= "<input type=hidden name=PID value=\"$PID\">";
	if (isset($CID)) $out .= "<input type=hidden name=CID value=\"$CID\">";
	if (isset($FID)) $out .= "<input type=hidden name=FID value=\"$FID\">";
	if (isset($DID)) $out .= "<input type=hidden name=DID value=\"$DID\">";
$out .="	
<CENTER>
<p style='margin-top:2.0pt'> </p>
<input type=image  border=0 src='./img/send.gif' name='sendchat' value='Отправить'>
</CENTER>
</FORM>

";

?>