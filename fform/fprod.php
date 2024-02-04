<?
include("../include/checkadmin.php");
if (isset($Cancel)){
  exit(header("Location: acateg.php?CID=$form[CID]"));
}

// массив для поля select
$lf_value[]=0; $lf_textval[]="Корень";
$r=mysql_query("SELECT CID, name, tip, parent FROM ok_categories WHERE tip <> 3 order by parent, pnum, tip");
while($Row=mysql_fetch_row($r)) {
  $lf_value[]=$Row[0]; $lf_textval[]=$Row[1];  
}
if (!isset($form)){  // Первоначальные данные
	$res=mysql_query("SELECT * FROM ok_products WHERE PID='$PID'");
	$form=mysql_fetch_assoc($res); $lf_default = $form[CID];
}else{
  if (rtrim($form[name])=="") $error[name][]='поле не заполненo';
}


$icon="../pictures/i_$form[PID].gif";
if (file_exists($icon)) $form[icon]="<img src=$icon width=100>"; else  $form[icon]="ИЗОБРАЖЕНИЕ НЕ ЗАГРУЖЕНО $icon";

$picture="../pictures/p_$form[PID].gif"; 
if (file_exists($picture)) $form[picture]="<img src=$picture width=300>";else  $form[picture]="ИЗОБРАЖЕНИЕ НЕ ЗАГРУЖЕНО $picture";

//------------------------------------------
if ($form[upload1]<>''){
$size= filesize($form[upload1]);
copy($form[upload1], "../pictures/i_$form[PID].gif");
}

if ($form[upload2]<>''){
$size= filesize($form[upload2]);
copy($form[upload2], "../pictures/p_$form[PID].gif");
}

//------------------------------------------


define("loginform",1); include_once("_fform.php");
$buf=loginform_show("../fform/_prod.lf"); //ВНИМАНИЕ: ТУТ НУЖНО УКАЗАТЬ ИМЯ ФОРМЫ

if (isset($onSubmit) && !isset($error)){
	//$form[description] = str_replace("\"", "\\\"", $form[description]); $form[description] = str_replace("'", "\'", $form[description]);
	//$form[info] = str_replace("\"", "\\\"", $form[info]); $form[info] = str_replace("'", "\'", $form[info]);
	$query ="UPDATE ok_products
	SET 	CID='$form[CID]',
		pnum='$form[pnum]',
		name='$form[name]',
		description='$form[description]', 
		info='$form[info]', 
		show_special='$form[show_special]', 
		price='$form[price]',
		defaultico='$form[defaultico]',	
		old_price='$form[old_price]',
		href_url='$form[href_url]',
		
		visible='$form[visible]'
	WHERE PID='$form[PID]'";
	$result = MYSQL_QUERY($query); 
header("Location: acateg.php?CID=$form[CID]");
}
?>