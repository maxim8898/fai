<?
error_reporting(0);
// ���������� ������� �������
session_start();
$login = $_SESSION['login'];
$pass = $_SESSION['pass'];
$nick = $_SESSION['nick'];
if (isset($PID)) settype($PID,'integer');
if (isset($CID)) settype($CID,'integer');
if (isset($FID)) settype($FID,'integer');
if (isset($DID)) settype($DID,'integer');
if (isset($DDID)) settype($DDID,'integer');
if (isset($inside)) settype($inside,'integer');



$searchstring =  trim(substr($searchstring, 0, 20));
$searchstring = mysql_real_escape_string($searchstring);

extract($_POST); extract($_GET);

include_once("config/connect.php"); include_once("config/config.php"); 
include_once("include/function.php"); 
//mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("������ ����������� � MySQL"); mysql_select_db(DB_NAME) or die("������ ����������� � ��");	
@mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("������ �������� ����������"); @mysql_query("SET NAMES 'cp1251'"); @mysql_select_db(DB_NAME) or die("������ �������� ����������");	

include_once("include/level.php");
$output = implode("",file("templ/print.html")); 

$out = ""; $out1 = "����������";

include_once("include/main.php");
$title = str_replace("<b>", "", $title);
$title = str_replace("</b>", "", $title);
$title = str_replace("<p>", "", $title);
$title = str_replace("</p>", "", $title);
$title = str_replace("<br>", "", $title);


$output = str_replace("{TITLE}", $title, $output);


echo $output;
?>