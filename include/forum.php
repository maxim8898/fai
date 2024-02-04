<?
$out =""; $out1 =""; $i =0;
$descriptions=""; $keywords=""; $title="";
$out1 ="<b> Список форумов ";

if ($FID ==0){
  $out .="<TABLE border=0 width=100% cellpadding=2 cellspacing=0>";
  $out .="<TR><TD class=lf_tr width=100% bgcolor = $dark_color><b><font color ='#ffffff'>Обсуждение публикаций и материалов сайта</font></b></TD><TD class=lf_tr bgcolor = $dark_color>Тем</TD><TD class=lf_tr bgcolor = $dark_color>Сообщ.</TD><TD class=lf_tr bgcolor = $dark_color>Последнее</TD></TR>";
  $r=mysql_query("SELECT CID, name, lasttime, lastnick FROM ok_categories WHERE visible = 1 and tip <> 3 and discussion =1 order by parent, pnum");
  while($Row=mysql_fetch_array($r)) {
	$descriptions .="$Row[name]. ";
	$rr=mysql_query("SELECT count(*) FROM ok_products WHERE CID=$Row[CID] and visible = 1");
	$t_count = mysql_fetch_row($rr); $t_count = $t_count[0];
	$rr=mysql_query("SELECT count(*) FROM ok_discussions WHERE CID=$Row[CID]");
	$p_count = mysql_fetch_row($rr); $p_count = $p_count[0];
	if ($Row[lasttime]) $time = date("d.m.Y H:i", $Row[lasttime]-$localtime * 3600); else $time = '';
	$out .="<TD class=lf_tr><a href=index.php?FID=$Row[CID]>$Row[name]</a></TD>
		<TD class=lf_tr>$t_count</TD>
		<TD class=lf_tr>$p_count</TD>
		<TD class=lf_tr>$time<br>$Row[lastnick]</TD>
		</TR>";
  }

  $r=mysql_query("SELECT parent, CID, name FROM ok_categories WHERE visible = 1 and tip = 3 and discussion =1 and parent=0");
  while($R=mysql_fetch_array($r)) {
	$descriptions .="$R[name]. ";
	$out .="<TR><TD class=lf_tr width=100% bgcolor = $dark_color><b><font color ='#ffffff'>$R[name]</font></b></TD><TD class=lf_tr bgcolor = $dark_color>Тем</TD><TD class=lf_tr bgcolor = $dark_color>Сообщ.</TD><TD class=lf_tr bgcolor = $dark_color>Последнее</TD></TR>";
	$p=mysql_query("SELECT CID, name, lastnick, lasttime FROM ok_categories WHERE visible = 1 and parent=$R[CID]");
	$ii = 0;
         while($Row=mysql_fetch_array($p)) {
	$rr=mysql_query("SELECT count(*) FROM ok_products WHERE CID=$Row[CID] and visible = 1");
	$t_count = mysql_fetch_row($rr); $t_count = $t_count[0];
	$rr=mysql_query("SELECT count(*) FROM ok_discussions WHERE CID=$Row[CID]");
	$p_count = mysql_fetch_row($rr); $p_count = $p_count[0];
         $ii +=1;
	If ($ii%2){
	    $out .="<TR>";
	}Else{
	    $out .="<TR bgcolor='#eaeff4'>";
	}

         if ($Row[lasttime]) $time = date("d.m.Y H:i", $Row[lasttime]-$localtime * 3600); else $time = '';
	 	$out .="<TD class=lf_tr><a href=index.php?FID=$Row[CID]>$Row[name]</a></TD>
		<TD class=lf_tr>$t_count</TD>
		<TD class=lf_tr>$p_count</TD>
		<TD class=lf_tr>$time<br>$Row[lastnick]</TD>
		</TR>";
	}
  }
  $out .="</TABLE>";


}else{
  $out1 ="<b><a href=index.php?FID=0> Форумы </a>:";
  $r=mysql_query("SELECT CID, name, description FROM ok_categories WHERE visible = 1 and CID='$FID'");
  $R=mysql_fetch_array($r); $out1 .=" $R[name] ";
  $descriptions .="$R[name]. ";

  if (isset($login)) $out .="<a href=index.php?act=newforum&CID=$R[CID]>Новая тема</a>";
  $out .="<TABLE border=0 width=100% cellpadding=2 cellspacing=0>";
  $out .="<TR><TD class=lf_tr bgcolor = $dark_color>ico</TD><TD class=lf_tr width=100% bgcolor = $dark_color><b><font color ='#ffffff'>$R[name]</font></b></TD><TD class=lf_tr bgcolor = $dark_color>Всего</TD><TD class=lf_tr bgcolor = $dark_color>Автор</TD><TD class=lf_tr bgcolor = $dark_color>Просм.</TD><TD class=lf_tr bgcolor = $dark_color>Последнее</TD></TR>";

//------------------------------
// страничный навигатор
$rr=mysql_query("SELECT count(*) from ok_products WHERE visible = 1 and CID='$FID'");
$g_count = mysql_fetch_row($rr); $g_count = $g_count[0];
if ($offset>$g_count || !isset($offset)) $offset=0;
$limit="LIMIT $offset, 20";
showNavigator($g_count, $offset, 20, "index.php?FID=$FID&",&$out1);
//---------------------------------

  $r=mysql_query("SELECT CID, PID, name, lasttime, lastnick, author, fcounter, description FROM ok_products WHERE visible = 1 and CID='$FID' order by lasttime DESC $limit");
  $ii =0;
  while($Row=mysql_fetch_array($r)) {
	$descriptions .="$Row[name]. ";
	$rr=mysql_query("SELECT count(*) FROM ok_discussions WHERE PID=$Row[PID]");
	$p_count = mysql_fetch_row($rr); $p_count = $p_count[0];
	if ($Row[lasttime]) $time = date("d.m.Y H:i", $Row[lasttime]-$localtime * 3600); else $time = '';

         $ii +=1;
	If ($ii%2){
	    $out .="<TR>";
	}Else{
	    $out .="<TR bgcolor='#eaeff4'>";
	}
	$out .="<TD class=lf_tr>&nbsp;</TD>
		<TD class=lf_tr><a href=index.php?DID=$Row[PID]>$Row[name] $Row[model]</a></TD>
		<TD class=lf_tr>$p_count</TD>
		<TD class=lf_tr>$Row[author]&nbsp;</TD>
		<TD class=lf_tr>$Row[fcounter]</TD>
		<TD class=lf_tr>$time<br>$Row[lastnick]</TD>
		</TR>";
  }
  $out .="</TD></TR></TABLE>";
//  $out .="</table><TABLE border='1' width='100%' cellpadding='0' cellspacing='3'><TR><TD colspan='2' height='23' bgcolor='#4e7dc1'><font size=-1 color=#ffffff>$out1</font></TD></TR>";

}
$keywords=$descriptions; $title=$descriptions;
?>
