<?
include("../include/check.php");
if (isset($Cancel)){
  exit(header("Location: aforum.php?C=$form[parent]"));
}
if (!isset($form)){  // Первоначальные данные
	$res=mysql_query("SELECT * FROM ok_categories WHERE CID='$CID'");
	$form=mysql_fetch_assoc($res);
}else{
  if (rtrim($form[name])=="") $error[name][]='поле не заполненo';
}


// массив для поля select
$lf_value[]=0; $lf_textval[]="Корень"; $lf_default = 0;

define("loginform",1); include_once("_fform.php");
$buf=loginform_show("../fform/_forum.lf"); //ВНИМАНИЕ: ТУТ НУЖНО УКАЗАТЬ ИМЯ ФОРМЫ

if (isset($onSubmit) && !isset($error)){
  if (isset($New)){
echo "Добавление CID=$form[CID]";
  }else{
	$form[description] = str_replace("\"", "\\\"", $form[description]); $form[description] = str_replace("'", "\'", $form[description]);
	$query ="UPDATE ok_categories
	SET 	tip=3,
		name='$form[name]',
		parent=0,
		description='$form[description]',
		discussion='$form[discussion]',
		visible='$form[visible]'
	WHERE CID='$form[CID]'";
  }
	$result = MYSQL_QUERY($query);
header("Location: aforum.php?C=$form[parent]");
}
?>
