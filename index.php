<?
error_reporting(0);
// Управление главной панелью
session_start();

extract($_POST); extract($_GET);

if (isset($PID)) settype($PID,'integer');
if (isset($CID)) settype($CID,'integer');
if (isset($FID)) settype($FID,'integer');
if (isset($DID)) settype($DID,'integer');
if (isset($DDID)) settype($DDID,'integer');
if (isset($inside)) settype($inside,'integer');



$searchstring =  trim(substr($searchstring, 0, 20));
//$searchstring = mysql_real_escape_string($searchstring);
//echo"CID=$CID PID=$PID FID=$FID DID=$DID login=$login act=$act level=$level";

include_once("config/connect.php"); include_once("config/config.php");
include_once("include/function.php");
//mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("Ошибка подключения к MySQL"); mysql_select_db(DB_NAME) or die("Ошибка подключения к БД");
@mysql_connect(DB_HOST,DB_USER,DB_PASS) or die("Сервис временно недоступен"); @mysql_query("SET NAMES 'cp1251'"); @mysql_select_db(DB_NAME) or die("Сервис временно недоступен");
//include_once("include/level.php");
$output = implode("",file("templ/index.html"));
$outtmp = implode("",file("templ/top.tpl"));$output = str_replace("{TOP}", $outtmp, $output);
$outtmp = implode("",file("templ/menu.tpl"));$output = str_replace("{MENU}", $outtmp, $output);
$outtmp = implode("",file("templ/center.tpl"));$output = str_replace("{CENTER}", $outtmp, $output);
$outtmp = implode("",file("templ/down.tpl"));$output = str_replace("{DOWN}", $outtmp, $output);
$outtmp = implode("",file("templ/left.tpl"));$output = str_replace("{LEFT}", $outtmp, $output);
$outtmp = implode("",file("templ/main.tpl"));$output = str_replace("{MAIN}", $outtmp, $output);
$outtmp = implode("",file("templ/right.tpl"));$output = str_replace("{RIGHT}", $outtmp, $output);

$out = ""; $out1 = "Информация";

include_once("include/main.php");
include_once("include/left.php");
include_once("include/right.php");



$title = str_replace("<b>", "", $title);
$title = str_replace("</b>", "", $title);
$title = str_replace("<p>", "", $title);
$title = str_replace("</p>", "", $title);
$title = str_replace("<br>", "", $title);
$title = str_replace("<a", "", $title);
$title = str_replace("</a>", "", $title);
$title = str_replace("<img", "", $title);
$title = str_replace("href=", "", $title);
$title = str_replace("src=", "", $title);
$title = str_replace("border=", "", $title);
$title = str_replace(">", "", $title);





$descriptions = str_replace("<b>", "", $descriptions);
$descriptions = str_replace("</b>", "", $descriptions);
$descriptions = str_replace("<p>", "", $descriptions);
$descriptions = str_replace("</p>", "", $descriptions);
$descriptions = str_replace("<br>", "", $descriptions);
$descriptions = str_replace("<a", "", $descriptions);
$descriptions = str_replace("</a>", "", $descriptions);
$descriptions = str_replace("<img", "", $descriptions);
$descriptions = str_replace("href=", "", $descriptions);
$descriptions = str_replace("src=", "", $descriptions);
$descriptions = str_replace("border=", "", $descriptions);
$descriptions = str_replace(">", "", $descriptions);




$keywords = str_replace("<b>", "", $keywords);
$keywords = str_replace("</b>", "", $keywords);
$keywords = str_replace("<p>", "", $keywords);
$keywords = str_replace("</p>", "", $keywords);
$keywords = str_replace("<br>", "", $keywords);
$keywords = str_replace("<a", "", $keywords);
$keywords = str_replace("</a>", "", $keywords);
$keywords = str_replace("<img", "", $keywords);
$keywords = str_replace("href=", "", $keywords);
$keywords = str_replace("src=", "", $keywords);
$keywords = str_replace("border=", "", $keywords);
$keywords = str_replace(">", "", $keywords);




$sitename ="FAI F3A в Беларуси. Сайт белорусских пилотажников";	# Название сайта
$title = $sitename;
$descriptions = $sitename;
$keywords = $sitename;


$output = str_replace("{TITLE}", $title, $output);
$output = str_replace("{DESCRIPTIONS}", $descriptions, $output);
$output = str_replace("{KEYWORDS}", $keywords, $output);

$output = mb_convert_encoding($output, "utf-8", "windows-1251");
echo $output;
?>
