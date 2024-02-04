<?
//	include_once("shopping.php");
//	$output = str_replace("{SHOPPING}", $out, $output);
//	$output = str_replace("{CARTS}", $out2, $output);

	include_once("news.php");
	$output = str_replace("{NEWS}", $out, $output);

	include_once("voting.php");
	$output = str_replace("{VOTING}", $out, $output);
?>