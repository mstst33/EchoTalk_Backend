<?php
include "connect_db.php";

$row = '123'.'/'.'mstst'.'/'.'345'.'#$3'.'13'.'/'.'mst'.'/'.'35'.'#$3'.'12343'.'/'.'msthgj'.'/'.'35344';
$row = '1385473556795%3#$%shkoma%3#$%0%3#$%2013.11.26 22:45:56';
$try1 = getSimpleSpliter($row, '%3#$%', '/', 5);

$rows = '1385615642349%3#$%shkoma%3#$%photo_1385650587937.png%3#$%ì•ˆë…•í•˜ì„¸ìš”%3#$%2013.11.28 14:14:2';

$lastPos = 0;
// $lastPos = strlen($rows) - $lastPos;
$lastPos = substr($rows, 0, 3);

echo $try1.'<br>';

// echo $lastPos;

echo getSimpleSpliterLimited($rows, '%#3$%', ';', 5, 1, 10, 0);

mysql_close($connect);

function getSimpleSpliter($original, $from, $to, $length){
	$replacedString = $original;
	
	while(strpos($replacedString, $from, 0) !== false){
		$startPos = strpos($replacedString, $from, 0);
		$replacedString = substr($replacedString, 0, $startPos).$to.substr($replacedString, $startPos + $length, strlen($original) - 1);
	}
	
	return $replacedString;
}

function getSimpleSpliterLimited($original, $from, $to, $length, $writingnum, $limitcount, $number){
	$replacedString = strrev($original);
	$from = strrev($from);
	$to = strrev($to);
	$lastPos = 0;
	$count = 0;
	
	for($i = 0; $i < $number * $limitcount; ++$i){
		if(strpos($replacedString, $from, $lastPos) !== false){
			$lastPos = strpos($replacedString, $from, $lastPos);
			echo $lastPos.'<br>';
		}
	}
	
	$startPos = $lastPos;
	for($i = 0; $i < $limitcount; ++$i){
		if(strpos($replacedString, $from, $startPos) !== false){
			$startPos = strpos($replacedString, $from, $startPos);
			$replacedString = substr($replacedString, $lastPos, $startPos).$to.substr($replacedString, $startPos + $length, strlen($original));
			
			++$count;
			echo $startPos.'<br>';
		}
	}
	
	if($count == $writingnum - $number * $limitcount){
		$replacedString = strrev(substr($replacedString, $lastPos, $startPos - $lastPos));
	}
	else{
		if(strpos($replacedString, $from, $startPos) !== false){
			$startPos = strpos($replacedString, $from, $startPos);
		}
		else{
			$startPos = strlen($original);
		}
		
		$replacedString = strrev(substr($replacedString, $lastPos, $startPos - $lastPos));
		echo $startPos.'<br>';
		echo $lastPos.'<br>';
	}
	
	return $replacedString;
}
?>