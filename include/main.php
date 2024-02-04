<?php
//echo"CID=$CID PID=$PID";
if (isset($error)){
  include_once("config/error.php");
  $out1="<center><font color=red>ОШИБКА</color></center>";
  $out = $err[$error];
//--------------------------------------------------
}else{
  if (isset($CID)) $CID = htmlspecialchars(trim($CID), ENT_QUOTES);
  if (isset($PID)) $PID = htmlspecialchars(trim($PID), ENT_QUOTES);
  if (isset($FID)) $FID = htmlspecialchars(trim($FID), ENT_QUOTES);
  if (isset($DID)) $DID = htmlspecialchars(trim($DID), ENT_QUOTES);

  if (isset($DDID) && isset($del) && $del==1){
	$rd = mysql_query("select login from ok_discussions WHERE DID='$DDID'");
	$RowD=mysql_fetch_array($rd);
	if ($level > 70 || $login == $RowD[login]){
    		mysql_query("DELETE FROM ok_discussions WHERE DID ='$DDID'");
	}
	$rr=mysql_query("SELECT count(*) from ok_discussions D, ok_users U WHERE D.login=U.login and D.PID=$DID");
	$g_count = mysql_fetch_row($rr); $g_count = $g_count[0];
	if ($offset>$g_count || !isset($offset)) $offset=0;
  }

  if (isset($newmess) && $ftext<>"" && $newmess<>''){
  	$ftext = htmlspecialchars(trim($ftext), ENT_QUOTES); $topic = htmlspecialchars(rtrim($topic), ENT_QUOTES);
  	for ($i = 1; $i <= 20; $i++) {
    	  $ftext = str_replace (":sm$i:", "<img src=\'./img/sm$i.gif\'>", $ftext);
  	}
	$ftext = str_replace ("[p]", "<p>", $ftext); $ftext = str_replace ("[/p]", "</p>", $ftext);
	$ftext = str_replace ("[b]", "<b>", $ftext); $ftext = str_replace ("[/b]", "</b>", $ftext);
	$ftext = str_replace ("[i]", "<i>", $ftext); $ftext = str_replace ("[/i]", "</i>", $ftext);
	$ftext = str_replace ("[u]", "<u>", $ftext); $ftext = str_replace ("[/u]", "</u>", $ftext);
	$ftext = str_replace ("[Center]", "<center>", $ftext); $ftext = str_replace ("[/Center]", "</center>", $ftext);
	$ftext = str_replace ("[br]", "<br>", $ftext);
	$ftext = str_replace ("[Quote]", "<font size=-2><br>Цитата:</font><p style=\'font-style:italic;background-color:$middle_color;\'>", $ftext);
	$ftext = str_replace ("[/Quote]", "</p>", $ftext);
	$time = time();
	if (isset($DID)) $P=$DID; else $P=$PID;
	$result = MYSQL_QUERY("INSERT INTO ok_discussions SET login='$login', PID='$P', body='$ftext', time='$time', topic='$topic', CID='$C'");
        $result = MYSQL_QUERY("UPDATE ok_products SET lastnick='$nick', lasttime='$time' where PID=$P");
	$result = MYSQL_QUERY("UPDATE ok_categories SET lastnick='$nick', lasttime='$time' where CID=$C");
  }
  if (isset($act)){
    if ($act=='freg'){
	$out1="<center>Регистрация на сайте</center>";
	include_once("fform/freg.php");  $out .= $buf;
    }else  if ($act=='ftest_osen2010'){
	$out1="<center>Форма регистрации участника соревнований</center>";
	include_once("fform/ftest_osen2010.php");  $out .= $buf;

    }else  if ($act=='fuser'){
	$out1="<center>Персональные данные</center>";
	include_once("fform/fuser.php");  $out .= $buf;
    }else  if ($act=='forgot'){
	$out1="<center>Восстановление пароля</center>";
	include_once("fform/remember.php");  $out .= $buf;
    }else  if ($act=='newforum'){
	$out1="<center>Новая тема на форуме</center>";
	include_once("fform/newforum.php");  $out .= $buf;
    }else  if ($act=='search'){
	$out1="<center>Результаты поиска</center>";
	if ($searchstring <> ''){
	  include_once("poisk.php");
	}else{
	  $out.="Не задана строка поиска";
	}
    }

  }else if (isset($stat)){
	//include_once("stats.php");
	include_once("./stat/view.php");

  }else if (isset($CID)) { // Просмотр категорий
	include_once("catview.php");

  }else if (isset($FID)) { // Просмотр форумов
	include_once("forum.php");

  }else if (isset($PID) && $PID) { // Просмотр продуктов

    if (isset($DID)){ // Просмотр содержания материала
      include_once("disview.php");
    }else{
      if (isset($mark)){
	if (!isset($vote_completed[$PID]) && $mark)
	$q = mysql_query("UPDATE ok_products SET rating=(rating*votes+$mark)/(votes+1), votes=votes+1 WHERE PID=$PID");
	$vote_completed[$PID] = 1;
	$_SESSION['vote_completed'] = $vote_completed;
			}
      include_once("prodview.php");
    }

  }else if (isset($DID)) { // просмотр форума
    include_once("disview.php");
  }else{
	include_once("catview.php");
  }
}
$output = str_replace("{INFO}", $out1, $output);
$output = str_replace("{TEXT}", $out, $output);

?>
