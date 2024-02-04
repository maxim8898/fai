<?php
$out = "";
$out .= "<Table width=100%>\n<Tr><Td>";
if (!isset($save_voting_results)) { //форма опроса
	$f = file("voting.txt");
	$r = file("results.txt");
	$m = $r[0] ? $r[0] : 0;
	$m = max($m, 1);
	for ($i=0; $i<count($r); $i++) if ($m < $r[$i]) $m = $r[$i];

	//форма опроса
	$out .= "<form action=\"index.php\" method=post>";
	$out .= "<table cellspacing=0 cellpadding=0 width=100%>";
	$out .= "<tr><td colspan=2><b>$f[0]</b></td></tr><tr><td>\n";
	for ($i=1; $i<count($f); $i++) {
		$out .= "<table cellspacing=0 cellpadding=0>
		<tr><td class=lf_tt><input type=radio name=opt value=$i></td>
		<td class=lf_tt width=100%>$f[$i]</td></tr></table>\n";
	};
	$out .= "</td></tr></table>";
	$out .= "<p> </p><center>
	<input type=hidden name=save_voting_results value='Ответить'>
	<input type=image  border=0 src='./img/send1.gif'>
	</center>";
	if (isset($PID)) $out .= "<input type=hidden name=PID value=\"$PID\">";
	if (isset($CID)) $out .= "<input type=hidden name=CID value=\"$CID\">";
	if (isset($CID)) $out .= "<input type=hidden name=FID value=\"$FID\">";
	if (isset($CID)) $out .= "<input type=hidden name=DID value=\"$DID\">";
	$out .= "</form>";

}else {	//результаты опроса
	$f = file("voting.txt");
	if (!($r = file("results.txt"))){
		$r = array();
		for ($i=0; $i<count($f)-1; $i++) $r[$i] = 0;
	}

	if (!isset($vote_completed[0]) && isset($opt))
		$r[$opt-1] = $r[$opt-1] + 1;

	//запись изменений
	$f1 = fopen("results.txt","w");
	for ($i=0; $i<count($r); $i++) fputs($f1, trim($r[$i])."\n");
	fclose($f1);

	//показать результаты
	$m = $r[0] ? $r[0] : 0;
	for ($i=0; $i<count($r); $i++) if ($m < $r[$i]) $m = $r[$i];
	$m = max($m, 1);
	$out .= "<table cellspacing=0 cellpadding=0 width=100% border=0>";
	$out .= "<tr><td colspan=3><b><font size=-1>$f[0]</font></b></td></tr>\n";
	for ($i=1; $i<count($f); $i++){
		$out .= "<tr><td class=lf_tt><font size=-1>$f[$i]</font></td>";
		$out .= "<td class=lf_tt>";
		if ($r[$i-1] > 0){
			$out .= "<table border=1 cellspacing=0 cellpadding=0><tr><td><nobr>";
			for ($j = 0; $j< 10*$r[$i-1]/$m; $j++) $out .= "<img src=\"./img/voter.gif\">";
			$out .= "</nobr></td></tr></table>";
		}
		$out .= "</td><td class=lf_tt width=1% align=center><font size=-1>".$r[$i-1]."</font>\n";
		$out .= "</td></tr>\n";
	}
	$out .= "</table>";
	$vote_completed[0] = 1;
	session_register("vote_completed");
}
$out .= "</Td></Tr></Table>";
?>
