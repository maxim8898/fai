<?php
$out ="";

$out .="<img src='../img/cur1.gif' width='8' height='9'><a href=index.php onClick=parent.left.location.reload('left.php')> Главная</a><br>";


if (!isset($CID)){
	$CID=0; $parent = 0;
}else{
	$r=mysql_query("SELECT parent, name FROM ok_categories WHERE CID='$CID'");
	$Row=mysql_fetch_row($r); $parent = $Row[0];
}
//$r=mysql_query("SELECT tip, parent, pnum, CID, name FROM ok_categories WHERE (parent='$CID' or parent= '$parent' or parent=0) and visible=1 and tip <> 3 order by parent, pnum");


$r=mysql_query("SELECT tip, parent, pnum, CID, name FROM ok_categories WHERE (parent='$CID' or parent= '$parent' or parent=0) and visible=1 and tip <> 3 order by  pnum");
while($Row=mysql_fetch_row($r)) {
  if ($CID == $Row[3]){
	$out .="<img src='../img/cur.gif' width='14' height='13'><a href=index.php?CID=$Row[3] onClick=parent.left.location.reload('left.php?CID=$Row[3]')> $Row[4]</a><br>";
  }else if ($Row[1] == 0){
	$out .="<img src='../img/cur1.gif' width='8' height='9'><a href=index.php?CID=$Row[3] onClick=parent.left.location.reload('left.php?CID=$Row[3]')> $Row[4]</a><br>";
  }else { //if ($Row[1]==$parent){
	$out .="&nbsp;&nbsp;<img src='../img/cur2.gif' width='8' height='9'><a href=index.php?CID=$Row[3]  onClick=parent.left.location.reload('left.php?CID=$Row[3]')> $Row[4]</a><br>";
  }
}
?>
