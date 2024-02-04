<?php
include("../include/check.php");
if (isset($Cancel)){
  exit(header("Location: anews.php"));
}


if (!isset($form)){  // Первоначальные данные
	$res=mysql_query("SELECT * FROM ok_news WHERE NID='$NID'");
	$form=mysql_fetch_assoc($res); $lf_default = $form[parent];
}

if ($form[date][2]<>'.' || $form[date][5] <> '.')
  $form[date]=date("d.m.Y", $form[date]);

$image1="../pictures/n_$form[NID].gif";
if (file_exists($image1))
	$form[image1]="<img src=$image1 width=60>";
else  $form[image1]="ИЗОБРАЖЕНИЕ НЕ ЗАГРУЖЕНО";


//------------------------------------------
if ($form[upload]<>''){
$size= filesize($form[upload]);
copy($form[upload], "../pictures/n_$form[NID].gif");
}
//------------------------------------------


define("loginform",1); include_once("../fform/_fform.php");
$buf=loginform_show("../fform/_news.lf"); //ВНИМАНИЕ: ТУТ НУЖНО УКАЗАТЬ ИМЯ ФОРМЫ

if (isset($onSubmit) && !isset($error)){
	$date = $form[date];
	$m = $date[0].$date[1]; $d = $date[3].$date[4]; $Y = $date[6].$date[7].$date[8].$date[9];
	$stamp = mktime(0,0,0,$d,$m,$Y);

	$query ="UPDATE ok_news
	SET 	pnum='$form[pnum]',
		date='$stamp',
		body='$form[body]',
		PID='$form[PID]',
		visible='$form[visible]'
	WHERE NID='$form[NID]'";
	$result = MYSQL_QUERY($query) or die (mysql_error());
	header("Location: anews.php");
}
?>
