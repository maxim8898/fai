<?
error_reporting(0);
session_start();
$ip = getRealIpAddr(); session_register("ip");

if ( isset($form[cod]) && $_SESSION[cod] <> md5($form[cod])){
  $error[cod][] = '��������� ��� �������������';
}

if (isset($onSubmit)) {
	if (eregi("[^�-��-�0-9a-z_]",$form[nick])) $error[nick][] = "������������ ������� � ���� ����� !";
	$form[nick] = strtr($form[nick], "�������������������", "ETOPAHKXCBMeyopakxc"); 
	if (eregi("[^�-��-�0-9a-z_]",$form[nick])) $error[nick][] = "������������ ������� � ���� ��� !";
	$form[email] = strtolower($form[email]);

	if ($form[login]) {
	$res=mysql_query("SELECT login FROM ok_users WHERE login='$form[login]'");
	$Row=mysql_fetch_array($res);
	if (count($Row)>1) $error[login][]="� ���������, ��������� ����� ��� �����";
	}
	if ($form[nick]) {
	$res=mysql_query("SELECT nick FROM ok_users WHERE nick='$form[nick]'");
	$Row=mysql_fetch_array($res);
	if (count($Row)>1) $error[nick][]="� ���������, ��������� ��� ��� �����";
	}
	if ($form[email]) {
	$res=mysql_query("SELECT email FROM ok_users WHERE email='".addslashes($form[email])."'");
	$Row=mysql_fetch_array($res);
	if (count($Row)>1) $error[email][]="������������ � ����� E-Mail ��� ���������������";
	}
}

define("loginform",1); include_once("_fform.php");
$buf=loginform_show("fform/_reg.lf"); //��������: ��� ����� ������� ��� �����

if (isset($onSubmit) && !isset($error)){
	$buf = "<center>����������� ������ �������!</center><br><p> �� ��������� ���� E-Mail ������� ������������� � ����������� �� �����. �� ������ ������������ ���� ������� (�������������� �� ����� � ���������� ������� �����/������) �� ������� 24 ����� � ������� ��������� �����������.</p>
	<p>� ���������� ��������������� ������ � ������ �� ������ �������� ���������������� ������� \"�������� ������\"."; 

	$pass = $form[pass];
//	$pass = ''; for ($i=0; $i<6; $i++)  $pass .= rand(0,9);
	$md5_pass = MD5($pass); 

	$form[email] = strtolower($form[email]);
	$datereg=time();
         $ip = getRealIpAddr();

	$query = "INSERT INTO ok_users
	SET 	login='$form[login]',
		pass='$md5_pass',
		nick='$form[nick]',
		email='$form[email]',
		pol='$form[pol]',
		hideemail='$form[hideemail]', 
	        datereg='$datereg', 
		ip='$ip'";  
	$result = MYSQL_QUERY($query); 
	$mail = "������������.\n\n\n�� ������������������ �� ����� \"$sitename\".\n\n";
	$mail.= "���� ��������������� ������:\n\n";
        $mail.= "����� : $form[login]\n";
	$mail.= "������: $pass\n";
	$mail.= "\n�� ������ ������������ ���� ������� (�������������� �� ����� � ���������� ������� �����/������) �� ������� 24 ����� � ������� ��������� �����������.";
	$mail.= "\n\n\n��� ��������� ������� �������� �������. ����������, �� ��������� �� ��� ������ c ������� ������� \"��������\"";
        $mail.= "\n$email";
	mail($form[email], "����������� �� ����� \"$sitename\"", "$mail", "From: \"$sitename\"<$email>;\nContent-Type: text/plain; charset=\"windows-1251\"\nReturn-path: <$email>");
}
?>