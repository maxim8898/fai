<?
$shopping = 1; $out=''; $out2='';
if (isset($login) && $shopping){
	$out = implode("",file("templ/shopping.tpl"));

	$out2 = "<input type=text size='22' name=gc value='товаров'><br>
		 <input type=text size='22' name=ca value='на сумму'>";


}

?>
