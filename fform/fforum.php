<?
include("../include/check.php");
if (isset($Cancel)){
  exit(header("Location: aforum.php?C=$form[parent]"));
}

// ������ ��� ���� select
$lf_value[]=0; $lf_textval[]="������";
$r=mysql_query("SELECT CID, name, tip, parent FROM ok_categories  WHERE parent=0 and tip=3");
while($Row=mysql_fetch_row($r)) {
  $lf_value[]=$Row[0]; $lf_textval[]=$Row[1];  
}
if (!isset($form)){  // �������������� ������
	$res=mysql_query("SELECT * FROM ok_categories WHERE CID='$CID'");
	$form=mysql_fetch_assoc($res); $lf_default = $form[parent];
}else{
  if (rtrim($form[name])=="") $error[name][]='���� �� ��������o';
}


define("loginform",1); include_once("_fform.php");
$buf=loginform_show("../fform/_forum.lf"); //��������: ��� ����� ������� ��� �����

if (isset($onSubmit) && !isset($error)){
	$form[description] = str_replace("\"", "\\\"", $form[description]); $form[description] = str_replace("'", "\'", $form[description]);
	$query ="UPDATE ok_categories
	SET 	tip=3,
		name='$form[name]', 
		parent='$form[parent]',
		description='$form[description]', 
		discussion='$form[discussion]', 
		visible='$form[visible]'
	WHERE CID='$form[CID]'";
	$result = MYSQL_QUERY($query); 
header("Location: aforum.php?C=$form[parent]");
}
?>