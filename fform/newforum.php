<?
if (!isset($login)) exit(header("Location: ../index.php?error=1"));
if (isset($Cancel)){
  exit(header("Location: index.php?FID=$CID"));
}
if (!isset($form)){  // Ïåðâîíà÷àëüíûå äàííûå
  $form[CID] = $CID; $form[visible] = 1; 
}else{
  if (rtrim($form[name])=="") $error[name][]='ïîëå íå çàïîëíåío';
  if (rtrim($form[message])=="") $error[message][]='ïîëå íå çàïîëíåío';
}

define("loginform",1); include_once("_fform.php");
$buf=loginform_show("fform/_newforum.lf"); //ÂÍÈÌÀÍÈÅ: ÒÓÒ ÍÓÆÍÎ ÓÊÀÇÀÒÜ ÈÌß ÔÎÐÌÛ

if (isset($onSubmit) && !isset($error)){
	$time = time();
	$form[message] = htmlspecialchars(rtrim($form[message]), ENT_QUOTES); $form[name] = htmlspecialchars(rtrim($form[name]), ENT_QUOTES);
	$form[message] = str_replace ("[p]", "<p>", $form[message]); $form[message] = str_replace ("[/p]", "</p>", $form[message]);
	$form[message] = str_replace ("[b]", "<b>", $form[message]); $form[message] = str_replace ("[/b]", "</b>", $form[message]);
	$form[message] = str_replace ("[i]", "<i>", $form[message]); $form[message] = str_replace ("[/i]", "</i>", $form[message]);
	$form[message] = str_replace ("[u]", "<u>", $form[message]); $form[message] = str_replace ("[/u]", "</u>", $form[message]);
	$form[message] = str_replace ("[center]", "<center>", $form[message]); $form[message] = str_replace ("[/center]", "</center>", $form[message]);
	$form[message] = str_replace ("[br]", "<br>", $form[message]); 

	$query = "INSERT INTO ok_products
	SET 	CID='$form[CID]',
		name='$form[name]',
		description='$form[description]',
		visible='$form[visible]', 
		date='$time',
	        lasttime='$time',
		lastnick='$nick', 
		author='$nick'";
  	$result = MYSQL_QUERY($query); 
	$PID =  mysql_insert_id();

	$query = "INSERT INTO ok_discussions
	SET 	CID='$form[CID]',
		PID='$PID',
		login='$login',
		time='$time',
	        topic='$form[name]',
		body='$form[message]'";
  	$result = MYSQL_QUERY($query); 

	$query = "UPDATE ok_categories
	SET 	lastnick='$nick',
		lasttime='$time'
		where CID=$form[CID]"; 
	$result = MYSQL_QUERY($query); 

  header("Location: index.php?DID=$PID");
}
?>