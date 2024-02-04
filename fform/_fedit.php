<?
   if (!defined('loginformedit')) exit("Константа loginformedit не определена, не правильный вызов программы. <P> <b>phpLoginForm</b> - <a href=http://php.spb.ru/phpLoginForm/>http://php.spb.ru/phpLoginForm/</a>");
   error_reporting(2047);
   @define('loginform',1);
   include('_fform.php');

   //$lf=array();

   if (!isset($sess)) $sess="";
   if (!isset($sessf)) $sessf="";

   $lf['name']=" ";

   $lf_def=
       array(
          '_var'=>"form",
          '_error'=>"error",
       );

$lf_def['_main']=<<<____TEXT____
[CSS]
<center>
<form action=[SELF] method=post>
   [SESSF]
    <input type=hidden name=onSubmit value=1>
   <input type=hidden name=c value=register>
   <table width=80% border=0 cellspacing=0 cellpadding=3 class=lf_table>
      [MAIN]
   </table>
   <P><input type=submit class=lf_submit>
</form>
</center>
____TEXT____;


$lf_def['_form']=<<<____TEXT____
<tr>
<td class=lf_tr width=60%>[DESCRIPTION]</td>
<td class=lf_tr width=40% <ERROR>bgcolor=#FFCCCC</ERROR>>
   [INPUT]
   <ERROR><center><b><font color=#aa0000>ОШИБКА ПРИ ЗАПОЛНЕНИИ:</font></b></center>[ERROR]</ERROR>
</td>
<td class=lf_tr width=1% align=center>
   <NEED><font color=red>обязательно заполнить</font></NEED>
   <NONEED>заполнять по желанию</NONEED>
</td>
</tr>
____TEXT____;


$lf_def['_css']=<<<____TEXT____
<STYLE><!--

/* ЗАГОЛОК ТАБЛИЦЫ */
.lf_table {
BORDER-RIGHT:  #eeeeee 2px outset;
BORDER-TOP:    #eeeeee 2px outset;
BORDER-LEFT:   #eeeeee 2px outset;
BORDER-BOTTOM: #eeeeee 2px outset;
BACKGROUND-COLOR: #D4D0C8;
}

/* ЯЧЕЙКА ТАБЛИЦЫ */
.lf_tr {
BORDER-RIGHT:  #aaaaaa 1px solid;
BORDER-TOP:    #eeeeee 1px solid;
BORDER-LEFT:   #eeeeee 1px solid;
BORDER-BOTTOM: #aaaaaa 1px solid;
font: 75% Tahoma;
}

/* ФОРМА ВВОДА */
.lf_input {
BORDER-RIGHT:  #ffffff 1px solid;
BORDER-TOP:    #999999 1px solid;
BORDER-LEFT:   #999999 1px solid;
BORDER-BOTTOM: #ffffff 1px solid;
BACKGROUND-COLOR: #e4e0d8;
font: 9pt Tahoma;
}

/* КНОПКА "SUBMIT" */
.lf_submit {
BORDER-RIGHT:  buttonhighlight 2px outset;
BORDER-TOP:    buttonhighlight 2px outset;
BORDER-LEFT:   buttonhighlight 2px outset;
BORDER-BOTTOM: buttonhighlight 2px outset;
BACKGROUND-COLOR: #e4e0d8;
width: 30%;
}

--></STYLE>
____TEXT____;


////////////////////////////////////////////////////////////////////////////////////////////////



   if ($lf['name']=="") exit("ERROR: параметр lf[name] не задан");

   if (!isset($c)) $c="";


function lfp_show($name,$form=array()) {
   global $lfp;
   if (count($form)==0) $flag=0; else $flag=1;
   foreach ($lfp as $k=>$v) {
      switch ($k) {
      case "type":
         $vals=explode(" "," text textarea password radio checkbox select file image");
         echo "<tr><td class=clf_tr>$k</td>
         <td class=clf_tr><select class=clf_input name=_lf[$name][$k] size=1>";
         foreach ($vals as $vv) @print("<option ".($form[$k]==$vv?"selected":"").">$vv");
         echo "</select></td><td class=clf_tr>$v</td></tr>";
         break;
      case "check":
         $vals=explode(" "," mail url icq inetger date");
         echo "<tr><td class=clf_tr>$k</td>
         <td class=clf_tr><select class=clf_input name=_lf[$name][$k] size=1>";
         foreach ($vals as $vv) @print("<option ".($form[$k]==$vv?"selected":"").">$vv");
         echo "</select></td><td class=clf_tr>$v</td></tr>";
         break;
      case "need":
      case "public":
      case "save":
      case "trim":
         if (!$flag) $form[$k]="1";
         @print("<tr><td class=clf_tr>$k</td>
         <td class=clf_tr><select class=clf_input name=_lf[$name][$k] size=1><option value=1 ".($form[$k]==1?"selected":"").">1 (да)<option value=0 ".($form[$k]==0?"selected":"").">0 (нет)</select>
         </td><td class=clf_tr>$v</td></tr>");
         break;
      case "textreg":
      case "default":
         @print("<tr><td class=clf_tr>$k</td>
         <td class=clf_tr width=50%><textarea class=clf_input name=_lf[$name][$k]
         rows=5 cols=30 style='width: 100%'>".(htmlspecialchars($form[$k]))."</textarea></td>
         <td class=clf_tr width=50%>$v</tD></tr>");
         break;
      default:
         @print("<tr><td class=clf_tr>$k</td>
         <td class=clf_tr><input style='width: 100%' class=clf_input type=text name=_lf[$name][$k] size=30 value=\"".(htmlspecialchars($form[$k]))."\"></td>
         <td class=clf_tr>$v</tD></tr>");
         break;
      }
   }
}






switch ($c) {

case "":

?>
<HTML><BODY>
<STYLE>
.clf_tr {
BORDER-RIGHT:  #aaaaaa 1px solid;
BORDER-TOP:    #eeeeee 1px solid;
BORDER-LEFT:   #eeeeee 1px solid;
BORDER-BOTTOM: #aaaaaa 1px solid;
font: 70% Tahoma;
}
.clf_table {
BORDER-RIGHT:  #eeeeee 2px outset;
BORDER-TOP:    #eeeeee 2px outset;
BORDER-LEFT:   #eeeeee 2px outset;
BORDER-BOTTOM: #eeeeee 2px outset;
BACKGROUND-COLOR: #D4D0C8;
}
.clf_input {
BORDER-RIGHT:  #ffffff 1px solid;
BORDER-TOP:    #999999 1px solid;
BORDER-LEFT:   #999999 1px solid;
BORDER-BOTTOM: #ffffff 1px solid;
BACKGROUND-COLOR: #e4e0d8;
font: 8pt Tahoma;
}
.clf_input2 {
BORDER-RIGHT:  #ffffff 1px solid;
BORDER-TOP:    #999999 1px solid;
BORDER-LEFT:   #999999 1px solid;
BORDER-BOTTOM: #ffffff 1px solid;
BACKGROUND-COLOR: #e4e0d8;
font: 8pt Courier, Lucida;
}
.clf_submit {
BORDER-RIGHT:  buttonhighlight 2px outset;
BORDER-TOP:    buttonhighlight 2px outset;
BORDER-LEFT:   buttonhighlight 2px outset;
BORDER-BOTTOM: buttonhighlight 2px outset;
BACKGROUND-COLOR: #e4e0d8;
width: 30%;
}
</STYLE>
<?

   echo $lf['name'];

   if (file_exists($lf['file']))
      $buf=unserialize(implode("",file($lf['file'])));
   else
      $buf=$lf_def;

   echo "<b>=Визуальный просмотр текущей формы=</b> На кнопку Submit этой формы нажимать не нужно!";
   echo loginform_show($buf);

   $num=0;
   foreach ($buf as $k=>$v) {
      if ($k[0]=="_") continue;
      $num++;
   }
   flush();

   echo "<a name=sort><P><hr size=1 noshade><P>
   <b>=Сортировка и удаление полей= </b>(всего полей: $num)
   <table class=clf_table border=0 cellspacing=0 cellpadding=3>";
   $i=0;
   foreach ($buf as $k=>$v) {
      if ($k[0]=="_") continue;
      echo "<tr><td class=clf_tr align=right>".($i+1)."</td>".
        "<td class=clf_tr><b><a href=#form_$i>$k</a></b> </td><td class=clf_tr>$v[type] </td>".
        "<td class=clf_tr>".(strlen($v['textreg'])>50?substr($v['textreg'],0,50)."...":$v['textreg'])." &nbsp; </td>".
        ($i>0?"<td class=clf_tr><a href='$PHP_SELF?c=up&n=$i&name=$k$sess'>выше</a></td>":"<td class=clf_tr>&nbsp;</td>").
        ($i+1<$num?"<td class=clf_tr><a href='$PHP_SELF?c=down&n=$i&name=$k$sess'>ниже</a></td>":"<td class=clf_tr>&nbsp;</td>").
        ($i>0?"<td class=clf_tr><a href='$PHP_SELF?c=up1&n=$i&name=$k$sess'>наверх</a></td>":"<td class=clf_tr>&nbsp;</td>").
        ($i+1<$num?"<td class=clf_tr><a href='$PHP_SELF?c=down1&n=$i&name=$k$sess'>вниз</a></td>":"<td class=clf_tr>&nbsp;</td>").
        "<td class=clf_tr><a href='$PHP_SELF?c=delete&n=$i&name=$k$sess' onClick='return confirm(\"Удалить это поле из формы?\")'>удалить</a></td>".
        "</tr>";
      $i++;
   }
   echo "</table>";
   flush();


   @print("<P><hr size=1 noshade><P><h3>Общие параметры формы</h3>
   <table class=clf_table border=0 cellspacing=3 cellpadding=>
   <form action=$PHP_SELF method=post>
   <tr><td>
   <input type=hidden name=c value=\"conf\">

   <center><b>Общий HTML шаблон формы ввода. </b></center>
   <small>Вместо <b>[MAIN]</b> автоматически вставляется код формы;
   <b>[CSS]</b> - стили из соответствующего поля ниже;
   <b>[SELF]</b> - \$PHP_SELF;
   <b>[SESS]</b> - строка из номера сессии для дописывания в URL;
   <b>[SESSF]</b> - строка для дописывая в форму.<br></small>
   <textarea class=clf_input2 name=_lf[_main] cols=70 rows=".lfrows(4,15,$buf['_main'])."
   style='width: 100%'>$buf[_main]</textarea><br>

   <P><center><b>HTML шаблон для вставки полей формы.</b></center>
   <small>Вместо <b>[INPUT]</b> автоматически вставляется код поля для ввода;
   <b>[DESCRIPTION]</b> - описание поля;
   <b>[ERROR]</b> - сообщение об ошибке.
   Все, что находится между <b>&lt;ERROR&gt;</b> и <b>&lt;/ERROR&gt;</b>
   будет показано только в случае ошибки,
   для <b>&lt;NEED&gt;&lt;/NEED&gt;</b> - обязатальное ли поле,
   для <b>&lt;NONEED&gt;&lt;/NONEED&gt;</b> - не обзятательное ли заполнение:<br></small>
   <textarea class=clf_input2 name=_lf[_form] cols=70 rows=".lfrows(4,15,$buf['_form'])."
   style='width: 100%'>".htmlspecialchars($buf[_form])."</textarea><br>

   <P><center><b>CSS стили для формы</b></center>
   <textarea class=clf_input2 name=_lf[_css] cols=70 rows=".lfrows(4,15,$buf['_css'])."
   style='width: 100%'>$buf[_css]</textarea><br>

   <P><center><b>Переменная '_var'</b></center>
   <small>Имя PHP-переменной, в которой будет передаваться форма при нажатии submit в форме регистрации
   для php-скрипта (в каком массиве это передавать). Именно в этой переменной и
   будет находится массив с автоматически проверенными значениями.<br></small>
   $<input type=text class=clf_input2 name=_lf[_var] size=30 value=\"$buf[_var]\"><br>

   <P><center><b>Переменная '_error'</b></center>
   <small>Имя PHP-переменной, в которой будут копиться ошибки о ходе заполенния
   формы. Эта переменная позволит в программе создать свои обработчики полей,
   которые не предумотрены стандартными проверками.<br></small>
   $<input type=text class=clf_input2 name=_lf[_error] size=30 value=\"$buf[_error]\"><br>
   </td></tr><tr><td>

   <center><input type=submit class=clf_submit></center>
   </td></tr></form></table>
   ");
   flush();


   echo "<P><hr size=1 noshade><P><h3>Редактирование полей формы</h3>
   <form action=$PHP_SELF method=post>
   <input type=hidden name=c value=\"add\">
   $sessf";
   $num=0;
   if (count($buf)) {
      foreach ($buf as $k=>$v) {
         if ($k[0]=="_") continue;
         $v['name']=$k;
         echo "<a name=form_$num></a><P><b>Поле N$num</b><table class=clf_table border=0 cellspacing=0 cellpadding=3>";
         lfp_show($k,$v);
         echo "</table><P>";
         $num++;
      }
   }
   if ($num==0)
      echo "Форма еще не создана: воспользуйтесь добавлением полей, чтобы начать
      создавать форму.<P>";
   else
      echo "<center><input type=submit class=clf_submit></center>";
   echo "</form>";



   echo "<P><hr size=1 noshade><P><h3>Добавить поле</h3>
   <table class=clf_table border=0 cellspacing=0 cellpadding=2>
   <form action=$PHP_SELF method=post>
   <input type=hidden name=c value=\"add\">
   $sessf";

   lfp_show("x");

   echo "<tr><td class=w colspan=3><center><input type=submit class=clf_submit></center></tD></tr></table>
   </form>";

   echo "<P><hr size=1 noshade><center><b>phpLoginForm</b> (c) Dmitry Borodin, <a href=http://php.spb.ru/phpLoginForm/>php.spb.ru</a></center>";

//   phpinfo();
break;



case "conf":

   if (file_exists($lf['file']))
      $buf=unserialize(implode("",file($lf['file'])));
   else
      $buf=$lf_def;

   foreach ($_lf as $k=>$v) {
      $buf[$k]=$v;
   }

   //echo "<pre>";print_r($_lf); print_r($buf); exit;

   $f=fopen($lf['file'],'wb+') or die("<br><br><font color=red>ERROR: can't open (w+) $lf[file]<br>нет прав открыть файл на запись/создание");
   fputs($f,serialize($buf));
   fclose($f);

   echo "<script>location.href='$PHP_SELF?c=$sess'</script>";

break;



case "add":


   if (file_exists($lf['file']))
      $buf=unserialize(implode("",file($lf['file'])));
   else
      $buf=$lf_def;
   foreach ($_lf as $k=>$v) {
      $name=$_lf[$k]['name'];
      if ($name=="") exit("Не введено имя поля [name]");
      unset($_lf[$k]['name']);
      if (empty($_lf[$k]['type'])) exit("Не задан тип [type] поля $name");
      $buf[$name]=$_lf[$k];
   }

   //unset($buf[""]);
   //echo "<pre>";print_r($_lf); print_r($buf); exit;

   $f=fopen($lf['file'],'wb+') or die("<br><br><font color=red>ERROR: can't open (w+) $lf[file]<br>нет прав открыть файл на запись/создание");
   fputs($f,serialize($buf));
   fclose($f);

   echo "<script>location.href='$PHP_SELF?c=$sess'</script>";

break;



case "delete":

   if (file_exists($lf['file'])) $buf=unserialize(implode("",file($lf['file'])));
   else $buf=$lf_def;
   unset($buf[$name]);
   $f=fopen($lf['file'],'wb+') or die("<br><br><font color=red>ERROR: can't open (w+) $lf[file]<br>нет прав открыть файл на запись/создание");
   fputs($f,serialize($buf));
   fclose($f);
   echo "<script>location.href='$PHP_SELF?c=$sess#sort'</script>";

break;


case "up":
case "down":

   if (file_exists($lf['file'])) $buf=unserialize(implode("",file($lf['file'])));
   else $buf=$lf_def;

   $i=0;
   $buf2=array();
   foreach ($buf as $k=>$v) {
      if ($k[0]=="_") { $buf2[$k]=$v; continue; }
      if ($c=="up") {
         if ($i+1==$n) { $buf2[$name]=$buf[$name]; $buf2[$k]=$v; }
         if ($name!=$k) $buf2[$k]=$v;
      }
      else {
         if ($name!=$k) $buf2[$k]=$v;
         if ($i-1==$n) { $buf2[$name]=$buf[$name]; $buf2[$k]=$v; }
      }
      $i++;
   }

   $f=fopen($lf['file'],'wb+') or die("<br><br><font color=red>ERROR: can't open (w+) $lf[file]<br>нет прав открыть файл на запись/создание");
   fputs($f,serialize($buf2));
   fclose($f);
   echo "<script>location.href='$PHP_SELF?c=$sess#sort'</script>";

break;


case "up1":
case "down1":

   if (file_exists($lf['file'])) $buf=unserialize(implode("",file($lf['file'])));
   else $buf=$lf_def;

   $buf2=array();
   if ($c=="up1") $buf2[$name]=$buf[$name];
   foreach ($buf as $k=>$v) if ($k!=$name) $buf2[$k]=$v;
   if ($c=="down1") $buf2[$name]=$buf[$name];

   $f=fopen($lf['file'],'wb+') or die("<br><br><font color=red>ERROR: can't open (w+) $lf[file]<br>нет прав открыть файл на запись/создание");
   fputs($f,serialize($buf2));
   fclose($f);
   echo "<script>location.href='$PHP_SELF?c=$sess#sort'</script>";

break;





}





?>
