<?
$ii =0;
 $i =0; $tip=0; $showrating=1; $order="ORDER by pnum";
if (!isset($CID) || $CID==0){ $CID=0; $parent = 0;$order="ORDER by pnum";}

$parent = $CID;
while($parent<>0) {
  $r=mysql_query("SELECT parent, name, CID, col, tip, showrating, sort FROM ok_categories WHERE CID='$parent' and visible = 1");
  $Row=mysql_fetch_array($r); $parent = $Row[parent]; 
  if ($Row[CID] == $CID){$nav[] = "$Row[name]"; $col =$Row[col]; $tip=$Row[tip]; $showrating=$Row[showrating]; $sort = $Row[sort];} else $nav[] = "<a href=index.php?CID=$Row[CID]>".$Row[name]."</a>";
}
if ($sort == 1) $order="ORDER by date"; else if ($sort == 2) $order="ORDER by rating DESC"; else if ($sort == 4) $order="ORDER by name";else $order="ORDER by pnum";
if ($CID == 0) $order="ORDER by pnum";
if(count($nav) >0) $nav[] ="<a href=index.php?CID=0>&nbsp;Главная</a>"; else $nav[] ="<b>&nbsp;Главная : Наиболее популярное на сайте ";
$out1 ="<b>";
for($j=count($nav); $j>=0;$j--){
  if($j==0 || $j==count($nav)){
    $out1 .= $nav[$j];
  }else{
    $out1 .= $nav[$j]." : ";
  }
}
$out1 .="</b>";

$where = " WHERE visible = 1 and (";
$r=mysql_query("SELECT tip, parent, pnum, CID, name, description  FROM ok_categories WHERE (parent='$CID' or CID='$CID') and visible = 1 and tip <> 3 $order");
$count = mysql_num_rows($r); 
If ($CID<>0){ 
  $descriptions=""; $keywords=""; $title="";
}else{
  $where =" WHERE visible = 1 and show_special=1";
  $limit="LIMIT 0, 21"; $nav=0;

}



If ($CID<>0){ 

if ($count>1){
  $out .="<table border=0 cellpadding=3 cellspacing=0 width=100%>";
  while($Row=mysql_fetch_array($r)) {
  $q = mysql_query("select count(*) from ok_categories WHERE parent = $Row[CID]");
  $cnt1 = mysql_fetch_row($q); $cnt = $cnt1[0]; 
  $q = mysql_query("select count(*) from ok_products WHERE CID = $Row[CID] or CID=$parent");
  $cnt1 = mysql_fetch_row($q); $cnt += $cnt1[0];

    if ($CID <> $Row[CID]){
	$image="pictures/c_$Row[CID].gif"; if (file_exists($image)); else  $image="pictures/c_0.gif";
	$where .= " CID=$Row[CID] or";
	$i++; if ($i/2 <> round($i/2)) $out .="</td></tr><tr>";
	$out .="</td><td width=50% class=lf_tr ><a href=index.php?CID=$Row[CID] onClick=parent.left.location.reload('left.php?CID=$Row[CID]')><img src=$image width='32' align='middle' border=0> $Row[name]"; if ($Row[parent] <> 0) $out .=" ($cnt)</a><br>";
    }
  }
  $where .= " CID=$CID) and show_special=1 "; $title1 = "<b>Наиболее популярное в разделе</b>"; $limit="LIMIT 0, 21"; $nav=0;
  $out .="</td></tr></table>";
}else{
	$Row=mysql_fetch_array($r);
         If ($CID<>0){ 
	  $descriptions = "$Row[name]. $Row[description]. ";
         } 
	$image="pictures/$Row[CID].gif"; if (file_exists($image)); else  $image="pictures/c_0.gif";
	$out .="<table width=100% border=0 cellpadding=3 cellspacing=0><tr>";
	$out .="<td width=40><img src=$image width='32' border=0></td><td><center><h1>$Row[name]</h1></center><p>$Row[description]</p></td></tr>";
	$where = " WHERE visible=1 and CID=$CID "; $title1 ="<b>Содержание раздела: </b>"; $nav=1;
}

}else{
//  $out .="=====  $where  ======";
}






$rr=mysql_query("SELECT count(*) FROM ok_products $where");
$g_count = mysql_fetch_row($rr); $g_count = $g_count[0];
if ($offset>$g_count || !isset($offset)) $offset=0;
if ($col == 2) $max=20;else $max = 10; if($tip=5) $max=50; 
if ($nav) $limit="LIMIT $offset, $max";

//$r=mysql_query("SELECT PID, name, model,  rating, votes, counter, description, show_special FROM ok_products $where $order $limit");
$r=mysql_query("SELECT PID, name, rating, votes, counter, description, show_special, defaultico FROM ok_products $where $order $limit");
if ($count<=1){
  $out .="</td></tr></table>"; // закрываем гл. таблицу из main.html
}

if ($g_count > 0){
if ($nav){ $title1 .="<b>"; showNavigator($g_count, $offset, $max, "index.php?CID=$CID&",&$title1);}
$out .="<TABLE border='0' width='100%' cellpadding='3' cellspacing='0' bgcolor='$main_color'>";



if ($col==2){
  $out .="<TR><TD class=lf_tr colspan='2' height='23' background='./img/but_f.gif'><FONT color=#000000>$title1</FONT></TD></TR>";

}else{
  if ($title1 != ''){

    $out .="<TR><TD class=lf_tr height='23' background='./img/but_f.gif'><b><font color=#000000>$title1</font><b></TD></TR>";
  }	
}


$i=0; $ii =0;


while($Row=mysql_fetch_array($r)) {
         If ($CID<>0){ 
           $descriptions .="$Row[name]. ";
	}
	$i++; if ($col<>2) $out .="<TR><TD colspan='2' align='left'>"; else{ if ($i/2 <> round($i/2)) $out .="<TR><TD width=50% align='left'>"; else $out .="<TD widnt=50% align='left'>";}

         $ii +=1;
	If ($ii%2){
	    $out .="<TABLE border='0' width='100%' cellpadding='3' cellspacing='0'><TR><TD>";
	}Else{
	    $out .="<TABLE border='0' width='100%' cellpadding='3' cellspacing='0'><TR bgcolor='#ffffff'><TD>";
	}


	$pict = "pictures/i_$Row[PID].gif";
	if (file_exists($pict)){
	  $out .= "<a href=index.php?PID=$Row[PID]><img src=$pict width=100 border=0 alt='$Row[name] $Row[model]'></a>";
	}else{
           if ($Row[defaultico]==1){
	     $out .= "<a href=index.php?PID=$Row[PID]><img src='pictures/p_0.gif' width=100 border=0 alt='$Row[name] $Row[model]'></a>";
           }
         }
        $out .="</TD><TD width=100%>";
	$out .= "<a href=index.php?PID=$Row[PID]>$Row[name] $Row[model]</a><br>";
	if ($Row[rating] > 0){
		for ($k=0; $k<round($Row[rating]); $k++) $out .= "<img src='img/star_r.gif'>";
		for (    ; $k < 5; $k++) $out .= "<img src='img/star_b.gif'>";
	}
	//$out .=" Просмотров: $Row[counter]";
	if ($Row[description]){
	  $out .="<br><br>$Row[description]";
	}
	$out .="</TD></TR></TABLE></TD>";
	if ($i/2 == round($i/2) || $col <>2 ) $out .="</TR>";
}
$out .="</TABLE>";
}else{
  $title1 = '';
}
$keywords=$descriptions; $title=$descriptions;

?>