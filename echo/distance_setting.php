<?php
$near = 5;
$far = 20;
$very_far = 100;

function getKMBetweenDistances($gpsNow, $gpsOther) {
	$gps1 = array();
	$gps2 = array();
	$gps1 = getExplodedString($gpsNow);
	$gps2 = getExplodedString($gpsOther);
	
	$lat_do1 = floor($gps1[0]);
	$lat_min_temp = ($gps1[0] - $lat_do1) * 60;
	$lat_min1 = floor($lat_min_temp);
	$lat_sec1 = ($lat_min_temp - $lat_min1) * 60;
	
	$lon_do1 = floor($gps1[1]);
	$lon_min_temp = ($gps1[1] - $lon_do1) * 60;
	$lon_min1 = floor($lon_min_temp);
	$lon_sec1 = ($lon_min_temp - $lon_min1) * 60;
	
	$lat_do2 = floor($gps2[0]);
	$lat_min_temp = ($gps2[0] - $lat_do2) * 60;
	$lat_min2 = floor($lat_min_temp);
	$lat_sec2 = ($lat_min_temp - $lat_min2) * 60;
	
	$lon_do2 = floor($gps2[1]);
	$lon_min_temp = ($gps2[1] - $lon_do2) * 60;
	$lon_min2 = floor($lon_min_temp);
	$lon_sec2 = ($lon_min_temp - $lon_min2) * 60;
	
	$lat_do = $lat_do1 - $lat_do2;
	$lat_min = $lat_min1 - $lat_min2;
	$lat_sec = $lat_sec1 - $lat_sec2;
	
	$lon_do = $lon_do1 - $lon_do2;
	$lon_min = $lon_min1 - $lon_min2;
	$lon_sec = $lon_sec1 - $lon_sec2;
	
	$dis_lat = $lat_do * 111 + $lat_min * 1.85 + $lat_sec * 0.031;
	$dis_lon = $lon_do * 88.8 + $lon_min * 1.48 + $lon_sec * 0.025;
	
	$distance = pow(pow($dis_lat, 2) + pow($dis_lon, 2), 1 / 2);
	
	return $distance;  
}

function getExplodedString($string){
	$strTok = explode(' ' , $string);
	$cnt = count($strTok);
	
	$result = array();
	for($i = 0 ; $i < $cnt ; $i++){
		$result[$i] = $strTok[$i];
	}
	
	return $result;
}
?>