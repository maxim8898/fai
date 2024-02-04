<?
$out .= "подключен файл function.php";

function getRealIpAddr()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    $ip=$_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}


function ShowNavigator($a, $offset, $q, $path, &$out)
{	//линейка навигации [пред] 1 2 3 4 : [след]
	//$a - кол-во элементов в массиве для вывода
	//$offset - текущий элемент (выводятся элементы [$offset ... $offset+$q])
	//$q - количество элементов на одной странице
	//$path - ссылка на страницу ( "index.php?СID=СID&" )

	if ($a > $q){ // нужна страничная разбивка
		//[пред]
		if ($offset>0) $out .= "<a href=\"".$path."offset=".($offset-$q)."\">[пред]</a> &nbsp;";

		//разбивка на страницы
		$k = $offset / $q;
		$min = $k - 5;
		if ($min < 0) { $min = 0; }
		else {
			if ($min >= 1){ // ссылка на 1 страницу
				$out .= "<a href=\"".$path."offset=0\">[1-".$q."]</a> &nbsp;";
				if ($min != 1) { $out .= "... &nbsp;"; };
			}
		}

		for ($i = $min; $i<$k; $i++){
			$m = $i*$q + $q;
			if ($m > $a) $m = $a;
			$out .= "<a href=\"".$path."offset=".($i*$q)."\">[".($i*$q+1)."-".$m."]</a> &nbsp;";
		}

		$min = $offset+$q;
		if ($min > $a) $min = $a;
		$out .= "[".($k*$q+1)."-".$min."] &nbsp;";

		$min = $k + 6;
		if ($min > $a/$q) { $min = $a/$q; };
		for ($i = $k+1; $i<$min; $i++) {
			$m = $i*$q+$q;
			if ($m > $a) $m = $a;
			$out .= "<a href=\"".$path."offset=".($i*$q)."\">[".($i*$q+1)."-".$m."]</a> &nbsp;";
		}

		if ($min*$q < $a) { //the last link
			if ($min*$q < $a-$q) $out .= " ... &nbsp;";
			$out .= "<a href=\"".$path."offset=".($a-$a%$q)."\">[".($a-$a%$q+1)."-".$a."]</a> ";
		}

		//[след]
		if ($offset<$a-$q) $out .= "<a href=\"".$path."offset=".($offset+$q)."\">[след]</a>";
	}
}
?>