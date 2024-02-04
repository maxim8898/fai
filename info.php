<?
function  geo_info($ip)
  {
    $xml = "<ipquery><fields><city/></fields><ip-list>"
         . "<ip>".$ip."</ip></ip-list></ipquery>";
    $ch = curl_init("http://194.85.91.253:8090/geo/geo.html");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    $result = curl_exec($ch);
    if(curl_errno($ch) != 0)
      die("curl_errno(".curl_errno($ch)."), curl_error(".curl_error($ch).")");
    curl_close($ch);
    if (strpos($result, '<message>Not found</message>') !== false)
      return false;
    preg_match("/<city>(.*)<\/city>/", $result, $city);
    return $city[1];
  }




$city = geo_info("213.180.204.8"); 
echo "Город - $city";


?>