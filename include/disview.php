<?
$out ="";  $out1 = ''; $var='PID';
$descriptions=""; $keywords=""; $title="";
if (!isset($PID)){ $PID=$DID; $forum=1; $var='DID';} else {$dop="&PID=$PID";}
$r=mysql_query("SELECT * FROM ok_products WHERE visible=1 and PID=$PID ");
$qq = mysql_query("UPDATE ok_products SET fcounter=fcounter+1 where PID=$PID");
$Row=mysql_fetch_array($r); $topic = "$Row[name] $Row[model]"; $C = $Row[CID];
$qq = mysql_query("UPDATE ok_products SET counter=counter+1 where PID=$PID");
$CID=$Row[CID];

//echo "<br>Row[CID] = $Row[CID]  offset=$offset";

if (isset($forum)){
  $rr=mysql_query("SELECT name FROM ok_categories WHERE visible=1 and CID=$Row[CID]");
  $R=mysql_fetch_array($rr);
  $out1 ="<b><a href=index.php?FID=0> Форумы </a>:";
  $out1 .=" <a href='index.php?FID=$Row[CID]'>$R[name]</a> :";
  $nav[0]=$out1;
  $out1 .=" $Row[name]";	
}else{
  $parent = $CID;
  $nav[]= "<a href=index.php?PID=$Row[PID]><b>$Row[name] $Row[model]</b></a>";
  while($parent<>0) {
	$r=mysql_query("SELECT parent, name, CID, tip FROM ok_categories WHERE CID='$parent' and visible = 1");
	$RowC=mysql_fetch_array($r); $parent = $RowC[parent]; 
	$nav[] = "<a href=index.php?CID=$RowC[CID]>".$RowC[name]."</a> ";
  }
  if(count($nav) >0) $nav[] ="<a href=index.php?CID=0>Главная</a>"; else $nav[] ="<b>Главная ";
 // $nav[] ="<a href=index.php?CID=0>Форумы</a>";
 $out1 ="<b>";
 for($j=count($nav); $j>=0;$j--){
   if($j==0 || $j==count($nav)){
     $out1 .= $nav[$j];
   }else{
     $out1 .= $nav[$j]." : ";
   }
 }
 $out1 .="</b>";
}

// страничный навигатор
$rr=mysql_query("SELECT count(*) from ok_discussions D, ok_users U WHERE D.login=U.login and D.PID=$PID");
$g_count = mysql_fetch_row($rr); $g_count = $g_count[0];
if ($offset>$g_count || !isset($offset)) $offset=0;
$limit="LIMIT $offset, 20";
if ($g_count > 20) $out1 = "<b>$nav[0] ";
showNavigator($g_count, $offset, 20, "index.php?DID=$DID$dop&",&$out1);
$ii = 0;
$r = mysql_query("select * from ok_discussions D, ok_users U WHERE D.login=U.login and D.PID=$PID ORDER BY time LIMIT $offset, 20");
while($Row=mysql_fetch_array($r)) {
  $ii += 1;
  $descriptions.="$Row[topic]. $Row[body].";
  $time = date("d.m.y H:i", $Row[time]-$localtime * 3600);

  If ($ii%2){
    $out .="<TABLE width=100%><TR valign='top'>";
  }Else{
    $out .="<TABLE width=100% bgcolor='#EAFAFA'><TR valign='top'>";
  }
  $out .="<TD class=lf_tr width=120>$time<br><b>$Row[nick]</b><br>$Row[status]</TD><TD class=lf_tr>";
  //$out .="<font size=-1><b>Тема: $Row[topic]</b></font><br>"; 
  $out .="<div style='text-align : justify;'>$Row[body]</div><BR><BR>";
  if (isset($login)){
    $out .="<table width=100%><tr><td>
    <INPUT type='image' onClick='document.post.ftext.focus(); window.scroll(0, 9999999)' src='img/send1.gif'>&nbsp;
    <INPUT type='image' onClick='TagsStyle(6); document.post.ftext.focus(); window.scroll(0, 9999999)' src='img/send2.gif'></td>";	
    if ($level > 70 || $login == $Row[login]){
      $out .="<td align=right>
      <INPUT type='image' onClick='' src='img/change.gif'>&nbsp;
      <INPUT type='image' onClick=\"javascript:confirmDelete('Удалить сообщение?','index.php?DDID=$Row[DID]&DID=$Row[PID]&del=1$dop&offset=$offset');\" src='img/del.gif'></td>";
    }
    $out .="</tr></table>";
  }
  $out .="</TD></TR></TABLE>";

  $out .="</TD></TR><TR><TD>";

}
$keywords=$descriptions; $title=$descriptions;
include_once("disnew.php");
?>