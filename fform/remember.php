<?

define("loginform",1); include_once("_fform.php");
$buf=loginform_show("fform/_remember.lf"); //��������: ��� ����� ������� ��� �����

if (isset($onSubmit)){
  $res=mysql_query("SELECT login, email FROM ok_users WHERE email='$form[email]'");
  $Row=mysql_fetch_array($res);
  if ($Row[0] == $form[login] && $Row[1]==$form[email]) {
	$ok=1;
  }else{
	exit(header("Location: index.php?error=2"));
  }
}

if (isset($onSubmit) && !isset($error) && $ok){
	$buf = "<center>�������� ���������!</center><br><p> �� ��� E-Mail ������� ������, ����������� ��� ������������� �� �����. ��������� �������������� ������ �������� �� ����� ��� ����� 1 ���.</p>";
	$pass = ''; for ($i=0; $i<6; $i++)  $pass .= rand(0,9);
	$md5_pass = MD5($pass); 
	$datereg=time();
	mysql_query("UPDATE ok_users SET pass='$md5_pass' WHERE login ='$form[login]'");
	$mail = "������������.\n\n\n�� �������� �������������� �������� ������ �� ����� \"$sitename\".\n\n";
	$mail.= "� ����� ������������ �������� ��� ������������ ����� ������. � ���������� �� ��� ������� ��������.\n\n";
	$mail.= "���� ��������������� ������:\n\n";
        $mail.= "����� : $form[login]\n";
	$mail.= "������: $pass\n";
	$mail.= "\n\n\n��� ��������� ������� �������� �������. ����������, �� ��������� �� ��� ������ c ������� ������� \"��������\"";
        $mail.= "\n$email";
	mail($form[email], "�������������� ������ �� ����� \"$sitename\"", "$mail", "From: \"$sitename\"<$email>;\nContent-Type: text/plain; charset=\"windows-1251\"\nReturn-path: <$email>");
}
?>