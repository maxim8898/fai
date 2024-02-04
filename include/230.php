<?php
$phptxt .="<TABLE width=100% border=0 cellpadding=3 cellspacing=1 bgcolor=000000><tr bgcolor=#9cb4ca> <td>Фамилия</td> <td>Имя</td> <td>Страна</td> <td>Город</td> <td>Разряд</td> <td>Комплекс</td> <td>Модель</td> <td>Двигатель</td> <td>Передатчик</td> <td>Канал</td> </tr>";

$res=mysql_query("SELECT * FROM test_osen2010 ORDER BY datereg");
//$tmp=mysql_fetch_assoc($res);
while($tmp=mysql_fetch_array($res)) {

$phptxt .="<tr bgcolor=white> <td><b>$tmp[fam]</b></td> <td><b>$tmp[name]</b></td> <td>$tmp[strana]</td> <td>$tmp[gorod]</td> <td>$tmp[razrad]</td> <td>$tmp[komplex]</td> <td>$tmp[model]</td> <td>$tmp[motor_name]</td> <td>$tmp[tx]</td> <td>$tmp[kanal]</td> </tr>";
}


$phptxt .="</table>";
?>
