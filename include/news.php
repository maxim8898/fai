<?php
// Публикация анонсов
$out='';
if (isset($login)){
  $res=mysql_query("SELECT pass, subscribe, email FROM ok_users WHERE login='$login'");
  $Row=mysql_fetch_assoc($res);
  if ($pass == $Row[pass] && $Row[pass]<>"" && $Row[subscribe]==0) {
	$oksub = 1;
	if (isset($subscribe)){
	  $oksub = 0;
	  $result = MYSQL_QUERY("UPDATE ok_users SET subscribe=1 WHERE login='$login'");
	}
  }
}
if ($oksub == 1){
  $out .= "<form action=\"index.php?subscribe=true\" name=\"form1\" method=post>";
}

if ($ordernews ==1) $order ="order by pnum"; else $order = "order by date DESC";
$q=mysql_query("SELECT * FROM ok_news WHERE visible=1 $order");

while ($row = mysql_fetch_assoc($q)){
	$date=date("d.m.Y", $row[date]);
	$image="./pictures/n_$row[NID].gif";
	if (file_exists($image)) $image="<img src=$image width=60 align=left border=0>"; else  $image="";
	$body = "$image$row[body]";
		if ($row[PID]<>0){
		  $body = "<a class=AA href=index.php?PID=$row[PID]>$body</a>";
	}

	$out .= "<table cellpadding=0 cellspacing=0 width='100%'>";
	$out .= "<tr><td class=lf_tr align=center bgcolor = $dark_color>$date</td></tr>";
	$out .= "<tr><td>$body<br></td></tr>";
	$out .= "</table>";
}

$out .= "<tr><td align=center>";
if ($oksub == 1)	{
	$out .= "<font class=light>Подписаться на новости</font><br><input type=text name=email value=\"$Row[email]\" size=22><br>";
	$out .= "<input type=submit class=redbutton value=\"OK\">";
	if (isset($PID)) $out .= "<input type=hidden name=PID value=\"$PID\">";
	if (isset($CID)) $out .= "<input type=hidden name=CID value=\"$CID\">";
	$out .= "</td></tr></form>";
}

?>
