<?php
if (isset($searchstring) && $searchstring <>''){
	$search = explode(" ",$searchstring);
	//поиск в категориях
	$s = "SELECT CID, name FROM ok_categories WHERE CID<>0 and visible=1 and name LIKE '%".$search[0]."%' ";
	for ($i=1; $i<count($search); $i++){
		$s .= "AND name LIKE '%".$search[$i]."%' ";
	}
	$s.="ORDER BY name";
	$q = mysql_query($s);
	$i=0; $outstr ="<TABLE border=0 width=100% cellpadding=2><tr><td class=lf_tr width=100% bgcolor = $dark_color><font color=#ffffff><b>Найдено в категориях</b></font></td></tr>";
	while ($row = mysql_fetch_assoc($q)){
	  $i++ ;  $outstr .="<tr><td class=lf_tr><a class='AA' href='index.php?CID=$row[CID]'> $row[name]</a></td></tr>";
	}
	$outstr .="</table>";
	if ($i > 0) $out .= $outstr;

	//поиск в продуктах
	$s_search = "SELECT PID, name FROM ok_products WHERE visible=1 and";
	$s_search .= "((name LIKE '%".$search[0]."%' OR description LIKE '%".$search[0]."%' OR info LIKE '%".$search[0]."%') ";
	for ($j=1; $j<count($search); $j++)
		$s_search .= "AND (name LIKE '%".$search[$j]."%' OR description LIKE '%".$search[$j]."%' OR info LIKE '%".$search[$j]."%') ";
	$s_search .= ") ";
	$q = mysql_query($s_search."ORDER BY rating DESC");
	$i=0;
	$i=0; $outstr ="<TABLE border=0 width=100% cellpadding=2><tr><td class=lf_tr width=100% bgcolor = $dark_color><font color=#ffffff><b>Найдено в материалах сайта</b></font></td></tr>";
	while ($row = mysql_fetch_assoc($q)){
	  $i++ ;  $outstr .="<tr><td class=lf_tr><a class='AA' href='index.php?PID=$row[PID]'> $row[name]</a></td></tr>";
	}
	$outstr .="</table>";
	if ($i > 0) $out .= $outstr;

	//поиск на форумах
	$s = "SELECT PID, topic FROM ok_discussions WHERE body LIKE '%".$search[0]."%' ";
	for ($i=1; $i<count($search); $i++){
		$s .= "AND body LIKE '%".$search[$i]."%' ";
	}
	$s.="ORDER BY time DESC";
	$q = mysql_query($s);
	$i=0; $outstr ="<TABLE border=0 width=100% cellpadding=2><tr><td class=lf_tr width=100% bgcolor = $dark_color><font color=#ffffff><b>Найдено на форумах</b></font></td></tr>";
	while ($row = mysql_fetch_assoc($q)){
	  $i++ ;  $outstr .="<tr><td class=lf_tr><a class='AA' href='index.php?DID=$row[PID]'> $row[topic]</a></td></tr>";
	}
	$outstr .="</table>";
	if ($i > 0) $out .= $outstr;


}




?>
