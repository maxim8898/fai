<?
//extract($_POST); extract($_GET);
   if (!defined('loginform')) exit("Константа loginform не определена, не правильный вызов программы. <P> <b>phpLoginForm</b> - <a href=http://php.spb.ru/phpLoginForm/>http://php.spb.ru/phpLoginForm/</a>");

$PHP_SELF = $_SERVER['PHP_SELF'];
$Self = $_SERVER['PHP_SELF'];
function lfpregtrim($str) {
   return preg_replace("/[^\x20-\xFF]/","",@strval($str));
}

function lfcheck_url($url) {
   // режем левые символы и крайние пробелы
   $url=trim(lfpregtrim($url));
   // если пусто - выход
   if (strlen($url)==0) return false;
   //проверяем УРЛ на правильность
   if (!preg_match("~^(?:(?:https?|ftp|telnet)://(?:[a-z0-9_-]{1,32}(?::[a-z0-9_-]{1,32})?@)?)?(?:(?:[a-z0-9-]{1,128}\.)+(?:com|net|org|mil|edu|arpa|gov|biz|info|aero|[a-z]{2})|(?!0)(?:(?!0[^.]|255)[0-9]{1,3}\.){3}(?!0|255)[0-9]{1,3})(?:/[a-z0-9.,_@%&?+=\~/-]*)?(?:#[^ '\"&<>]*)?$~i",$url,$ok))
   return false; // если не правильно - выход
   // если нет протокала - добавить
   if (!strstr($url,"://")) $url="http://".$url;
   // заменить протокол на нижний регистр: hTtP -> http
   $url=preg_replace("~^[a-z]+~ie","strtolower('\\0')",$url);
   return $url;
}


function lfcheck_mail($mail) {
   // режем левые символы и крайние пробелы
   $mail=trim(lfpregtrim($mail));
   // если пусто - выход
   if (strlen($mail)==0) return false;
   if (!preg_match("/^[a-z0-9_.-]{1,20}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is",$mail))
   return false;
   return $mail;
}

function lfcheck_icq($icq) {
   $icq=trim(lfpregtrim($icq));
   if (preg_match("!^[0-9]{5,15}$!",$icq)) return $icq;
   return false;
}

function lfcheck_int($int) {
   $int=trim(lfpregtrim($int));
   if ("$int"==intval($int)) return intval($int);
   return false;
}

function lfcheck_date($date) {
   $date=trim(lfpregtrim($date));
   if (preg_match("!^[0-9]{1,2}[./-][0-9]{1,2}[./-][0-9]{2,4}$!",$date)) return $date;
   return false;
}




function lfrows($mmin,$mmax,$str) {
  return max($mmin,min($mmax,count(explode("\n",$str))+2));
}

function lfexit($msg,$stop=1) {
   echo ("</td></tr></table></td></tr></table></td></tr></table></td></tr></table><br><br><br>
   <font color=red><b>
   Во время выполнения loginform_show() произошла ошибка,
   связанная с неверной настройкой формы. Откройте
   файл или массив, описывающий форму, и исправьте ошибку.
   Это не ошибка программы. Функция loginform_show() прервана.
   <br><br>Текст ошибки:<br><br><table width=100% border=0 cellspacing=0 cellpadding=6>
   <tr><td bgcolor=#ffaa99>&nbsp;<br>
   $msg<P></td></tr></table>
   </b></font>");
   if ($stop) exit;
}

//
// В качестве аргумента передать либо имя файла формы, либо саму форму в массиве
//

function loginform_show($obj) {

   global $HTTP_SERVER_VARS;

   if (is_array($obj)) $buf=$obj;
   else {
      if (!file_exists($obj)) lfexit("Не найден файл формы: $obj");
      $f=fopen($obj,"rb") or lfexit("Файл существует на диске, но нет прав открыть на чтение: $obj");
      $buf="";
      $fs=filesize($obj);
      $buf1=fread($f,$fs);
      $buf=unserialize($buf1);
      if (!is_array($buf)) {
         echo "\n\n\n\n\n<textarea rows=10 cols=70>".htmlspecialchars($buf1)."</textarea>\n\n\n\n\n\n";
         lfexit("loginform_show #1: Ошибка распаковки конфиг файла $obj (прочитано ".strlen($buf1)." байт из $fs)<P>\n
         Если в данный момент вы ставите чат, то проблема в следующем (иначе просто кем-то испорчен
         файл при копировании/переносе, но не чатом).<P>\n
         Видимо, вы не умеете копировать файлы по FTP, пытаясь поставить сейчас чат.
         Еще, весьма вероятно, что вы копировали файлы в наитупейшем FTP-менеджере
         CuteFTP. <u>Одним словом, во время выполнения инсталляции копируйте файлы
         FTP-клиентом, в которым включен <b>BINARY MODE</b> - режим передачи двоичных данных.</u>
         Рекомендуется копировать из FAR'а, в котором этот режим работает по-умолчанию.\n<P>
         Если копировать файлы чата в TEXT MODE, вместо BINARY, то файлы
         портятся, отличаются по содержимому и длине. Подробнее читайте в FAQ'е и UNIX.HTML.");
      }
      fclose($f);
   }

   $html="";

   $flag=0;
   $form=array();
   if (isset($GLOBALS[$buf['_var']])) {
      $flag=1;
      $form=$GLOBALS[$buf['_var']];
   }

   //pr($form);

   $error=array();
   if (isset($GLOBALS[$buf['_error']])) {
      $error=$GLOBALS[$buf['_error']];
   }

   if ($flag) {
      $form2=$buf['_var']."2";
      unset($GLOBALS[$form2]);
      $GLOBALS[$form2]=array();
      foreach ($form as $k=>$v) {
         if (!isset($buf[$k]) || $k[0]=="_") {
            unset($form[$k]);
            continue;
         }
         $GLOBALS[$form2][$k]=addslashes(@strval($v));
      }
   }

   foreach ($buf as $k=>$v) {

      if ($k[0]=="_") continue;
      if (!isset($form[$k]) && isset($form2)) $GLOBALS[$form2][$k]=0;

      $input=$v['html1'];
      $desc="";
      if ($v['type']=="text" || $v['type']=="textarea" || $v['type']=="password") {
         if (!isset($form[$k])) $form[$k]=$v['default'];
      }
      else {
         if (!$flag) $form[$k]=$v['default'];
      }

      if ($flag) {

         if ($v['trim'] && isset($form[$k])) $form[$k]=trim($form[$k]);
         if ($v['check='] && (!isset($form[$v['check=']]) || $form[$k]!=$form[$v['check=']]))
            $error[$k][]="это поле должно совпадать с ".$v['check=']." (введите в оба поля одно и тоже значение)";
         if ($v['type']!="checkbox" && $v['type']!="radio" && $v['type']!="file" && !isset($form[$k]))
            $error[$k][]="поле не передено (ошибочный HTTP-запрос)";
         if ((/*$v['type']=="checkbox" ||*/ $v['type']=="radio")
            && !isset($form[$k]) && $v['need'])
            $error[$k][]="поле не заполнено, пожалуйста, выберите один из вариантов";
         if (($v['type']=="radio" || $v['type']=="select")
            && $buf[$k]['need'] && isset($form[$k]) && $v['default']==$form[$k])
            $error[$k][]="поле осталось не измененным, пожалуйста, выберите любой из вариантов, кроме варианта по-умолчанию";
         if (!isset($error[$k]) && ($v['type']=="text" || $v['type']=="textarea" || $v['type']=="password")) {
            if ($form[$k]=="" && $v['need'])
               $error[$k][]="поле не заполнено";
            if ($form[$k]!="") {
               if ($v['sizemin']!="" && strlen($form[$k])<$v['sizemin'])
                  $error[$k][]="слишком короткое значение поля (минимум $v[sizemin] символов)";
               if ($v['sizemax']!="" && strlen($form[$k])>$v['sizemax'])
                  $error[$k][]="слишком большое значение поля (максимум $v[sizemax] символов)";
            }
         }

      }
      if ($flag && !($v['check']=="" || ($form[$k]=="" && $v['need']==0))) {
         $res="";
         switch ($v['check']) {
            case "int":
               $res=lfcheck_int($form[$k]);
               if ($res===false) {$error[$k][]="введите целое число"; continue;}
               $form[$k]=$res;
               break;
            case "date":
               $res=lfcheck_date($form[$k]);
               if ($res===false) {$error[$k][]="введите правильную дату: 00/00/00 или 00.00.0000"; continue;}
               $form[$k]=$res;
               break;
            case "icq":
               $res=lfcheck_icq($form[$k]);
               if ($res===false) {$error[$k][]="введите правильный номер ICQ"; continue;}
               $form[$k]=$res;
               break;
            case "url":
               $res=lfcheck_url($form[$k]);
               if ($res===false) {$error[$k][]="введите правильный URL"; continue;}
               $form[$k]=$res;
               break;
            case "mail":
               $res=lfcheck_mail($form[$k]);
               if ($res===false) {$error[$k][]="ошибочный E-mail"; continue;}
               $form[$k]=$res;
               break;
            default:
               lfexit("Неизвестный тип проверки формы в поле 'check' - [$v[check]]");
         }
      }

      switch ($v['type']) {

         case "text":
         case "password":
            //alert("$k - $form[$k]");
            $input.="<input type=$v[type] name=$buf[_var][$k] size='$v[cols]' maxsize='$v[sizemax]' ".
            "value=\"".htmlspecialchars($form[$k])."\" ".
            (empty($v['class'])?"":"class=$v[class] ").(empty($v['style'])?"":"style=\"$v[style]\" ").
            " $v[html]>";
            break;

         case "textarea":
            $input.="<textarea type=$v[type] name=$buf[_var][$k]".
            (empty($v['cols'])?"":" cols=$v[cols]").
            (empty($v['rows'])?"":" rows=$v[rows]").
            (empty($v['class'])?"":" class=$v[class]").(empty($v['style'])?"":" style=\"$v[style]\"").
            " $v[html]>$form[$k]</textarea>";
            break;

         case "checkbox":
            $input.="<input type=$v[type] name=$buf[_var][$k] ".
            "value=\"".(empty($v['value'])?"1":htmlspecialchars($v['value']))."\" ".
            (empty($form[$k])?"":"checked ").
            (empty($v['class'])?"":"class=$v[class] ").(empty($v['style'])?"":"style=\"$v[style]\" ").
            " id='lf-$k' $v[html]>".
            "<label for='lf-$k'>$v[textval]</label>";
            $desc=$v['textreg'];
            if ($flag && isset($form[$k])) $form[$k]=1; else $form[$k]=0;
            break;

	 case "file":
            $input.="<input type=$v[type] name=$buf[_var][$k] size='$v[cols]' ".
            (empty($v['class'])?"":"class=$v[class] ").(empty($v['style'])?"":"style=\"$v[style]\" ").
            " $v[html]>";
            break;

	case "image":
            $input.= $form[$k];
            break;

         case "radio":
         case "select":

            if (empty($v['value'])) return(lfexit("У поля [$k] не задан параметр [value]",0));
            if (empty($v['textval'])) return(lfexit("У поля [$k] не задан параметр [textval]",0));
            $vals=explode("--",$v['value']);
            $names=explode("--",$v['textval']);

            foreach ($vals as $kk=>$vv) {
               if (strpos($vv,"<AUTO>")!==false && preg_match("!<AUTO>([0-9]{1,9})-([0-9]{1,9})</AUTO>!",$vv,$ok)) {
                  if ($ok[1]>=$ok[2]) return(lfexit("У поля [$k] ошибка в тегах &lt;AUTO&gt;: сначала меньшее, потом большее число",0));
                  if ($ok[2]-$ok[1]>2100) return(lfexit("У поля [$k] ошибка в тегах &lt;AUTO&gt;: разница чисел не должна быть более 2100",0));
                  for ($i=$ok[1]; $i<$ok[2]; $i++) {
                     array_push($vals,$i);
                  }
                  unset($vals[$kk]);
               }
               if (strpos($vv,"<VAR>")!==false && preg_match("!<VAR>\\\$(lf_[A-Za-z0-9_]{2,100})</VAR>!",$vv,$ok)) {
                  if (isset($GLOBALS[$ok[1]]) && count($GLOBALS[$ok[1]]))
                     foreach ($GLOBALS[$ok[1]] as $kkk=>$vvv) array_push($vals,$vvv);
                  unset($vals[$kk]);
               }
            }
            foreach ($names as $kk=>$vv) {
               if (strpos($vv,"<AUTO>")!==false && preg_match("!<AUTO> *([0-9]{1,9}) *- *([0-9]{1,9}) *</AUTO>!",$vv,$ok)) {
                  if ($ok[1]>=$ok[2]) return(lfexit("У поля [$k] ошибка в тегах &lt;AUTO&gt;: сначала меньшее, потом большее число",0));
                  if ($ok[2]-$ok[1]>2100) return(lfexit("У поля [$k] ошибка в тегах &lt;AUTO&gt;: разница чисел не должна быть более 2100",0));
                  for ($i=$ok[1]; $i<$ok[2]; $i++) {
                     array_push($names,$i);
                  }
                  unset($names[$kk]);
               }
               if (strpos($vv,"<VAR>")!==false && preg_match("!<VAR>\\\$(lf_[a-z0-9_]{2,100})</VAR>!",$vv,$ok)) {
                  if (isset($GLOBALS[$ok[1]]) && count($GLOBALS[$ok[1]]))
                     foreach ($GLOBALS[$ok[1]] as $kkk=>$vvv) array_push($names,$vvv);
                  unset($names[$kk]);
               }
            }

            if ($flag && isset($form[$k]) && !in_array($form[$k],$vals))
               $error[$k][]="недопустимое значение в $v[type] (ошибочный HTTP-запрос)";

            if (count($vals)!=count($names)) return(lfexit("У поля [$k] не совпадают варианты ответов (параметр [value]) и сообщения для вариантов (параметр [textval])",0));

            if ($v['type']=="select") {
               $input.="<select name=$buf[_var][$k] size='$v[rows]' ".
                  (empty($v['class'])?"":"class=$v[class] ").(empty($v['style'])?"":"style=\"$v[style]\" ").
                  " id='lf-$k-$vv' $v[html]>";
               foreach ($vals as $kk=>$vv) {
                  $input.="<option value=\"$vv\"".(isset($form[$k]) && $form[$k]==$vv?" selected":"").">".$names[$kk];
               }
               $input.="</select>";
            }
            else {
               foreach ($vals as $kk=>$vv) {
                  $input.="<input type=$v[type] name=$buf[_var][$k] ".
                  "value=\"".htmlspecialchars($vv)."\" ".
                  (isset($form[$k]) && $vv==$form[$k]?"checked ":"").
                  (empty($v['class'])?"":"class=$v[class] ").(empty($v['style'])?"":"style=\"$v[style]\" ").
                  " id='lf-$k-$vv' $v[html]>".
                  "<label for='lf-$k-$vv'>$names[$kk]</label>";
               }
            }

            break;

         default:
            return(lfexit("[$v[type]] - неизвестный тип поля [$k]",0));

      }
if ($v['public']==0){ $html.="<input type='hidden' name=$buf[_var][$k] value=\"".htmlspecialchars($form[$k])."\" "; continue;}
      $input.=$v['html2'];
      if ($desc=="") $desc=$v['textreg'];
      $tmp=$buf['_form'];
      if ($v['need']) $tmp=preg_replace("!<NEED>(.+?)</NEED>!is","\\1",$tmp);
      else            $tmp=preg_replace("!<NEED>(.+?)</NEED>!is","",$tmp);
      if ($v['need']) $tmp=preg_replace("!<NONEED>(.+?)</NONEED>!is","",$tmp);
      else            $tmp=preg_replace("!<NONEED>(.+?)</NONEED>!is","\\1",$tmp);
      $err="";
      if (isset($error[$k])) $err="<li>".implode("<li>",$error[$k]);
      if ($err=="")
         $tmp=preg_replace("!<ERROR>(.+?)</ERROR>!is",$err,$tmp);
      else {
         $tmp=str_replace("<ERROR>","",$tmp);
         $tmp=str_replace("</ERROR>","",$tmp);
         $tmp=str_replace("[ERROR]",$err,$tmp);
      }
      $tmp=str_replace("[INPUT]",$input,$tmp);
      $tmp=str_replace("[DESCRIPTION]",$desc,$tmp);
      $html.=$tmp;

   }
   $main=$buf['_main'];
   $main=str_replace("[MAIN]",$html,$main);
   $main=str_replace("[CSS]",$buf['_css'],$main);
   //$main=str_replace("[SELF]",$HTTP_SERVER_VARS['PHP_SELF'],$main);
   //$main=str_replace("[SELF]",$Self,$main);
   $main=str_replace("[SESS]","&".session_name()."=".session_id(),$main);
   $main=str_replace("[SESSF]","<input type=hidden name='".session_name()."' value='".session_id()."'>",$main);

   if (count($error)>0) $GLOBALS[$buf['_error']]=$error;
   $GLOBALS[$buf['_var']]=$form;

   return $main;

}



?>
