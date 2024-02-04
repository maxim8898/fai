<?php
error_reporting(0);

//$rssURL = 'http://x.ru/my.rss';
class RSS {
	var $template_file = './include/template.rss';
	function assign($var, $value) {
		$this->$var = $value;
	}
	function display($rss_file = 'blah', $rss_items = 'blah', $rss_template_string = 'blah', $rss_template_file = 'blah', $rss_use_cache= 'blah', $rss_cache_dir = 'blah', $rss_refresh_time = 'blah', $rss_echo = 'blah', $rss_debug = 'blah') {
	global $rss_template;
	   $rss_items = $this->items; $rss_template_file = $this->template_file;
	   $f = fopen($rss_file,'r');
	   if ($f=='')
		$rss_template="В настоящее время данный ресурс недоступен. Повторите попытку через несколько минут.";
	   else{
		while (!feof($f)){$content .= fgets($f, 4096);}
		fclose($f);
		preg_match_all("'<item>(.+?)<title>(.*?)</title>(.+?)</item>'si",$content,$rss_item_titles);
		preg_match_all("'<item>(.+?)<link>(.*?)</link>(.+?)</item>'si",$content,$rss_item_links);
		preg_match_all("'<item>(.+?)<description>(.*?)</description>(.+?)</item>'si",$content,$rss_item_descriptions);
		preg_match_all("'<item>(.+?)<pubDate>(.*?)</pubDate>(.+?)</item>'si",$content,$rss_item_pubdate);

		$f = fopen($rss_template_file,'r');$rss_template = fread($f, filesize($rss_template_file));fclose($f);
		preg_match_all("'{rss_items}(.+?){/rss_items}'si",$rss_template,$rss_template_loop);
		$rss_template_loop = $rss_template_loop[1][0];
		$rss_template = str_replace('{rss_items}','',$rss_template);
		$rss_template = str_replace('{/rss_items}','',$rss_template);
		$k = count($rss_item_titles[2]);
		$j = (($rss_items == 'all') || ($rss_items > $k)) ? $k : intval($rss_items);
		for ($i = 0; $i<$j; $i++) {
			$tmp_template = $rss_template_loop;
			$tmp_title = $rss_item_titles[2][$i];
			$tmp_link = $rss_item_links[2][$i];
			$tmp_description = $rss_item_descriptions[2][$i];

			$tmp_pubdate = $rss_item_pubdate[2][$i];
			$tmp_pubdate = strtotime ($tmp_pubdate);
//			$tmp_pubdate = date("d.m.Y H:i ", $tmp_pubdate);
			$tmp_pubdate = date("d.m.Y ", $tmp_pubdate);

			if ($tmp_description == '') {
				$tmp_description = '-';
			}
			if ($tmp_title == '') {
				$tmp_title = substr($tmp_description,0,20);
				if (strlen($tmp_description) > 20) {
					$tmp_title .= '...';
				}
			}
			$tmp_template = str_replace('{$rss_item_title}',$tmp_title, $tmp_template);
			$tmp_template = str_replace('{$rss_item_link}',$tmp_link, $tmp_template);
			$tmp_template = str_replace('{$rss_item_description}',$tmp_description, $tmp_template);
			$tmp_template = str_replace('{$rss_item_pubdate}',$tmp_pubdate, $tmp_template);
			$tmp_template = str_replace('&lt;br&gt;','<br>', $tmp_template);
//$tmp_template = str_replace('+0400',' ', $tmp_template);
			$tmp_template = str_replace('http://news.yandex.ru/yandsearch?cl4url=','http://', $tmp_template);
			$rss_template_loop_processed .= $tmp_template;
		}
		$rss_template = str_replace($rss_template_loop, $rss_template_loop_processed, $rss_template);
		clearstatcache();
	   }
//	   echo $rss_template;
	}
}


$rss = new RSS();
$rss->assign('items', 15);
$rss->assign('use_cache', 1);
$rss->display($rssURL);
?>
