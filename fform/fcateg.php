<?php
include("../include/checkadmin.php");
if (isset($Cancel)){
  exit(header("Location: acateg.php?CID=$form[CID]"));
}

// массив для поля select
$lf_value[]=0; $lf_textval[]="Корень";
$r=mysql_query("SELECT CID, name, tip, parent FROM ok_categories  WHERE tip <> 3 and (CID=0 or parent=0) order by parent, pnum, tip");
while($Row=mysql_fetch_row($r)) {
  $lf_value[]=$Row[0]; $lf_textval[]=$Row[1];
}
if (!isset($form)){  // Первоначальные данные
	$res=mysql_query("SELECT * FROM ok_categories WHERE CID='$CID'");
	$form=mysql_fetch_assoc($res); $lf_default = $form[parent];
}else{
  if (rtrim($form[name])=="") $error[name][]='поле не заполненo';
}


$image1="../pictures/c_$form[CID].gif";
if (file_exists($image1))
	$form[image1]="<img src=$image1 width=32>";
else  $form[image1]="ИЗОБРАЖЕНИЕ НЕ ЗАГРУЖЕНО $image1";


//------------------------------------------
if ($form[upload]<>''){
$size= filesize($form[upload]);
copy($form[upload], "../pictures/c_$form[CID].gif");
}
//------------------------------------------


define("loginform",1); include_once("_fform.php");
$buf=loginform_show("../fform/_categ.lf"); //ВНИМАНИЕ: ТУТ НУЖНО УКАЗАТЬ ИМЯ ФОРМЫ

if (isset($onSubmit) && !isset($error)){
	//$form[description] = str_replace("\"", "\\\"", $form[description]); $form[description] = str_replace("'", "\'", $form[description]);
	$query ="UPDATE ok_categories
	SET 	pnum='$form[pnum]',
		tip='$form[tip]',
		col='$form[col]',
		name='$form[name]',
		parent='$form[parent]',
		description='$form[description]',
		discussion='$form[discussion]',
		showrating='$form[showrating]',
		sort='$form[sort]',
		visible='$form[visible]'
	WHERE CID='$form[CID]'";
	$result = MYSQL_QUERY($query) or die (mysql_error());
header("Location: acateg.php?CID=$form[CID]");
}
?>
