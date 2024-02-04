<?
$tmp = isset($searchstring) ? $searchstring : "";
$out = "
<form action='index.php' method=get>
<table border=0 width=100%>
  <COL span='1' align='left' width=100%>
  <COL span='1' align='left' width = '100%'>
  <COL span='1' align='left'>
<tr>
  <td>Поиск:</td>
  <td><input type=text name=searchstring size=40 value= $tmp></td>
  <td><input type=image border=0 src='./img/ok.gif'></td>
</tr><tr>
  <td  colspan=3>
  ";
	if (isset($PID)) $out .= "<input type=hidden name=PID value='$PID'>";
	if (isset($CID)) $out .= "<input type=hidden name=CID value='$CID'>";
	if (isset($CID)) $out .= "<input type=hidden name=FID value='$FID'>";
	if (isset($DID)) $out .= "<input type=hidden name=DID value='$DID'>";
  $out .="
  <input type='checkbox' name='inside' $tmp>искать в найденном
  <input type='hidden' name='act' value='search'>



  </td>
</tr>

</table>
</form>

";
?>

