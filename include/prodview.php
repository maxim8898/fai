<?php
$out =""; $out1 =""; $tip = 0; $showrating=0;
$descriptions=""; $keywords=""; $title="";
if (!isset($PID) || $PID==0){ $PID=0;}
$r=mysql_query("SELECT * FROM ok_products WHERE visible=1 and PID=$PID ");
$Row=mysql_fetch_array($r);
$qq = mysql_query("UPDATE ok_products SET counter=counter+1 where PID=$PID");
$CID=$Row[CID];
$parent = $CID;




//Unset($CID);
while($parent<>0) {
  $r=mysql_query("SELECT parent, name, CID, tip, discussion, showrating FROM ok_categories WHERE CID='$parent' and visible = 1");
  $RowC=mysql_fetch_array($r); $parent = $RowC[parent];
  if ($RowC[CID] == $CID){$tip = $RowC[tip]; $discussion =$RowC[discussion]; $showrating=$RowC[showrating];}
  $nav[] = "<a href=index.php?CID=$RowC[CID]>".$RowC[name]."</a>";
}

$nav[] ="<a href=index.php?CID=0>Главная</a>";
$out1 .="<b>";
for($j=count($nav); $j>=0;$j--){
  if($j==0 || $j==count($nav)){
    $out1 .= $nav[$j];
  }else{
    $out1 .= $nav[$j]." : ";
  }
}
$out1 .="</b>";

$q = mysql_query("select count(*) from ok_discussions D, ok_users U WHERE D.login=U.login and D.PID=$PID");
$cnt = mysql_fetch_row($q); $cnt = $cnt[0];
$descriptions .= "$Row[name] $Row[model]. ";
$out .="
<TABLE border='0' width='100%' cellpadding='0' cellspacing='3'>
<TR>
  <TD valign='top'>";
  $pict = "pictures/p_$PID.gif";
  if (file_exists("$pict")){
    $out .= "<img src=$pict width=300>";
  }else {
    $pict = "pictures/i_$PID.gif";
    if (file_exists("$pict")){
      $out .= "<img src=$pict width=100>";
    }else if ($Row[defaultico]==1){
      $out .= "<img src='pictures/p_0.gif'";
    }
  }
  $out .="
  </TD>
  <TD valign='top' align='left' valign='top' width='100%'>
	<center><h1>$Row[name] $Row[model]</h1></center>";
	if ($showrating){
	  $out .="Рейтинг ";
	  if ($Row[rating] > 0 ){
		$out .= "&nbsp;&nbsp;";
		for ($i=0; $i<round($Row[rating]); $i++) $out .= "<img src='img/star_r.gif'>";
		for (    ; $i < 5; $i++) $out .= "<img src='img/star_b.gif'>";
	  }
	  $out .=" ($Row[votes] голосов)<br>";
	}
	if ($discussion ==1){
	   $out .= "<a href=index.php?PID=$PID&DID=$PID>Комментарии </a>($cnt мнений)<br>";
	   $out .="Просмотров: $Row[counter]";
         }

	if ($tip == 2 && $Row[price]<>0){
	  $out .= "<br><b>Наша цена: <font color=red>$Row[price] руб.</font></b>";
	}
//  $Row[description] = htmlspecialchars($Row[description]);
  if ($Row[description]<> ""){
	$out .="<hr>$Row[description]"; $descriptions .= "$Row[description]. ";
  }
  $out .= "</TD>
  <TD valign='top'>";
//  if ($tip == 2) $out .="<img src= img/cart.gif><br>";
  if ($showrating){  // таблица голосования
	$out .= "
	<center>
	<form action='index.php' method=get>
	<table border=0 cellspacing=1 cellpadding=2 bgcolor=#$middle_color>
	<tr><td align=center>Ваша оценка</td></tr>
	<tr bgcolor=white><td>
	<input type='radio' name='mark' value='5' checked> Отлично<br>
	<input type='radio' name='mark' value='3.8'> Хорошо<br>
	<input type='radio' name='mark' value='2.5'> Средне<br>
	<input type='radio' name='mark' value='0.5'> Плохо
	</td></tr>
	</table>
	<input type='hidden' name='PID' value='$PID'>
	<input type='submit' value='Оценить!'"; if (isset($vote_completed[$PID])) $out .=" disabled"; $out .=">
	</form>
	</center>
	";
  }
  $out .="</TD>
</TR>
</TABLE>
";
if ($tip==5 && $Row[href_url]){
   $rssURL = $Row[href_url];
   include_once("parse_rss.php");
   $Row[info] = $rss_template;
}

if ($Row[info]<>""){

  if (strpos("$Row[info]","[php]") !== false){
    $phpfile="./include/$PID".".php";
    if (file_exists($phpfile)){
      include_once($phpfile);
      $Row[info] = str_replace("[php]", "$phptxt", $Row[info]);

    }
  }

  $Row[info] = str_replace("PID_URL", "print.php?PID", $Row[info]);
  $out .="<hr><p>$Row[info]</p>";
}



if ($discussion){
 // $out .= "</TABLE>"; // ok
  $topic = "$Row[name] $Row[model]";
  $C = $CID; $var='PID'; include_once("disnew.php");
}
$keywords=$descriptions; $title=$descriptions;
?>
