<?
error_reporting(0);
session_start();
$red = 0;
if (isset($Cancel)){
  exit(header("Location: index.php"));
}

$res=mysql_query("SELECT * FROM test_osen2011 WHERE ip='$ip'");
$tmp=mysql_fetch_assoc($res);
if (count($tmp) > 1){
  $red = 1;
  if(!isset($form)){
    $form = $tmp;
  }
}

if (isset($form[email]) && $red == 0){

  $res=mysql_query("SELECT * FROM test_osen2011 WHERE email='$form[email]'");
  $tmp=mysql_fetch_assoc($res);
  if (count($tmp) > 1){
    $error[email][] ='����� � ����� e-mail ��� ���������������';
  }
}

$ip = getRealIpAddr(); session_register("ip");


if ( isset($form[cod]) && $_SESSION[cod] <> md5($form[cod])){
  $error[cod][] = '��������� ��� �������������';
}

define("loginform",1); include_once("_fform.php");
$buf=loginform_show("./fform/_test_osen2011.lf"); //��������: ��� ����� ������� ��� �����
	
if (isset($onSubmit) && !isset($error)){
         $datereg=time();
	$form[email] = strtolower($form[email]);
  	if ($red == 1){
		$query ="UPDATE test_osen2011";
  	}else{
		$query ="INSERT INTO test_osen2011";

	}
	$query .=" SET 	ip='$ip',
		login='$login',
	  	fam='$form[fam]',
	  	name='$form[name]',
	  	ot='$form[ot]',
	  	email='$form[email]',
	  	strana='$form[strana]',
	  	gorod='$form[gorod]',
	  	kanal='$form[kanal]',
	  	razrad='$form[razrad]',
	  	komplex='$form[komplex]',
	  	model='$form[model]',
	  	motor_name='$form[motor_name]',
	  	tx='$form[tx]',
	  	date_r='$form[date_r]',
		datereg='$datereg',
	  	hotel='$form[hotel]',
	  	food='$form[food]',
		razmer='$form[razmer]',
		info='$form[info]',
		phone='$form[phone]'";
  	if ($red == 1){
	  $query .=" WHERE ip='$ip'";
	}
//echo"$query <br>";


	$result = MYSQL_QUERY($query); 
//echo"<br>RESULT=$result";


header("Location: index.php?PID=338");
}
?>
