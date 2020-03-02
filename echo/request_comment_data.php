<?php
include "connect_db.php";

$splitLength = 5;
$writingToShow = 20;
$dataToSend = 5;
$original = array();

$theme = $_POST['theme'];
$user_id = $_POST['user_id'];
$writing_num = $_POST['writing_num'];
$date = $_POST['date'];
$milli_second = $_POST['milli_second'];
$milli_del = $_POST['milli_del'];
$is_update = $_POST['is_update'];
$is_delete = $_POST['is_delete'];
$time = $_POST['time']; // time to upload comment
$comment = $_POST['comment'];


$headers = array('Content-Type:application/json',
 					'Authorization:key=');
	
	$arr   = array();
	$arr['data'] = array();
	$arr['data']['id'] = "$user_id";
	$arr['data']['msg'] = "$comment";
	$arr['data']['selectedInfo'] = "$theme";
	$arr['data']['writing_num'] = "$writing_num";
	$arr['registration_ids'] = array();

/*
$theme = '1';
$user_id = 'mstst';
$writing_num = '1385785511162';
$date = '2013.12.08 1:49:55';
$milli_second = '0';
$milli_del = '138570333744615';
$time = '138570333744615';
$comment = 'abddcccd';
$is_update = 'true';
$is_delete = 'trues';
*/

// $que = sprintf("DELETE from person where id='%s'", mysql_real_escape_string($user_id));

switch($theme){
	case 0:
		$que = sprintf("SELECT echo_num, echo, userid FROM normal_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 1:
		$que = sprintf("SELECT echo_num, echo, userid FROM travel_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 2:
		$que = sprintf("SELECT echo_num, echo, userid FROM exercise_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 3:
		$que = sprintf("SELECT echo_num, echo, userid FROM hobby_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 4:
		$que = sprintf("SELECT echo_num, echo, userid FROM study_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 5:
		$que = sprintf("SELECT echo_num, echo, userid FROM question_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 6:
		$que = sprintf("SELECT echo_num, echo, userid FROM work_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 7:
		$que = sprintf("SELECT echo_num, echo, userid FROM sellby_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
}

$re = mysql_query($que, $connect);

$returnvars = array();
if(!$re){
	$returnvars['is_success'] = "false";
}
else{
	$returnvars['is_success'] = "true";
	$row = mysql_fetch_row($re);
	
	// 루틴 처리
	if($is_delete == 'true'){
		$pos = getPositionOfString($row[0], $milli_second, $writingToShow);
		
		// Get string split
		$original = getSimpleSpliterLimited($row[1], '%#$3%', ';', $splitLength, $row[0], $writingToShow, $milli_second);
		$try1 = split(';',  $original[1]);
		$try2 = array();
		$count = count($try1);
		
		$getNumber = -1;
		for($i = 0; $i < $count; ++$i){
			$original2 = getSimpleSpliterLimited($try1[$i], '%3#$%', '/', $splitLength, $dataToSend, $writingToShow, 0);
			$try2[$i] = split('/',  $original2[1]);
			
			if($milli_del == $try2[$i][0]){
				$getNumber = $i;
			}
		}
		
		if($getNumber != -1){
			$count2 = count($try2[0]);
		
			for($i = 0; $i < $count; ++$i){
				if($i != $getNumber){
					if($pos == 2){
						if($getNumber == 0){
							if($i > 1)
								$wr .= '%#$3%';
						}
						else{
							if($i != 0)
								$wr .= '%#$3%';
						}
					}
					else{
						$wr .= '%#$3%';
					}
				
					for($j = 0; $j < $count2; ++$j){
						if(($j + 1) % 5 == 2){
							$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($try2[$i][$j]));
							$re = mysql_query($que, $connect);
							$picture_data = mysql_fetch_row($re);
							$try2[$i][$j + 1] = $picture_data[0];
						}
					
						if($j == $count2 - 1){
							$wr .= $try2[$i][$j];
						}
						else{
							$wr .= $try2[$i][$j].'%3#$%';
						}
					}
				}
			}
			
			if($pos == 0){
				if(!$wr){
					$original[0] = substr($original[0], $splitLength);
				}
				$wr .= $original[0];
			}
			else if($pos == 1){
				if(!$wr){
					$original[0] = substr($original[0], $splitLength);
					$original[2] = substr($original[2], 0, strlen($original[2]) - $splitLength);
				}
				
				$wr = $original[2].$wr;
				$wr .= $original[0];
			}
			else{
				if(!$wr){
					$original[2] = substr($original[2], 0, strlen($original[2]) - $splitLength);
				}
				$wr = $original[2].$wr;
			}
			
			switch($theme){
			case 0:
				$que = sprintf("update normal_table set echo_num=echo_num-1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 1:
				$que = sprintf("update travel_table set echo_num=echo_num-1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 2:
				$que = sprintf("update exercise_table set echo_num=echo_num-1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 3:
				$que = sprintf("update hobby_table set echo_num=echo_num-1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 4:
				$que = sprintf("update study_table set echo_num=echo_num-1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 5:
				$que = sprintf("update question_table set echo_num=echo_num-1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 6:
				$que = sprintf("update work_table set echo_num=echo_num-1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 7:
				$que = sprintf("update sellby_table set echo_num=echo_num-1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			}
			mysql_query($que, $connect);
			$returnvars['result'] = $wr;
			$returnvars['num'] = $row[0] - 1;
		}
		else{
			$returnvars['is_success'] = "false";
		}
	}
	else{
		if($is_update == 'true'){
			if($row[0] == 0){
				$str = $time.'%3#$%'.$user_id.'%3#$%'.'0'.'%3#$%'.$comment.'%3#$%'.$date;
			}else{
				$str = $row[1].'%#$3%'.$time.'%3#$%'.$user_id.'%3#$%'.'0'.'%3#$%'.$comment.'%3#$%'.$date;
			}
			
			// Get string split
			$original = getSimpleSpliterLimited($str, '%#$3%', ';', $splitLength, $row[0] + 1, $writingToShow, 0);
			$try1 = split(';',  $original[1]);
			$try2 = array();
			$count = count($try1);
		
			for($i = 0; $i < $count; ++$i){
				$original = getSimpleSpliterLimited($try1[$i], '%3#$%', '/', $splitLength, $dataToSend, $writingToShow, 0);
				$try2[$i] = split('/',  $original[1]);
			}
		
			$count2 = count($try2[0]);
			
			for($i = 0; $i < $count; ++$i){
				if($i != 0){
					$wr .= '%#$3%';
				}
				
				for($j = 0; $j < $count2; ++$j){
					if(($j + 1) % 5 == 2){
						$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($try2[$i][$j]));
						$re = mysql_query($que, $connect);
						$picture_data = mysql_fetch_row($re);
						$try2[$i][$j + 1] = $picture_data[0];
					}
					
					if($j == $count2 - 1){
						$wr .= $try2[$i][$j];
					}
					else{
						$wr .= $try2[$i][$j].'%3#$%';
					}
				}
			}
			
			switch($theme){
			case 0:
				$que = sprintf("update normal_table set echo_num=echo_num+1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 1:
				$que = sprintf("update travel_table set echo_num=echo_num+1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 2:
				$que = sprintf("update exercise_table set echo_num=echo_num+1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 3:
				$que = sprintf("update hobby_table set echo_num=echo_num+1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 4:
				$que = sprintf("update study_table set echo_num=echo_num+1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 5:
				$que = sprintf("update question_table set echo_num=echo_num+1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 6:
				$que = sprintf("update work_table set echo_num=echo_num+1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 7:
				$que = sprintf("update sellby_table set echo_num=echo_num+1, echo='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			}
			mysql_query($que, $connect);
			
			$returnvars['result'] = $wr;
			$returnvars['num'] = $row[0] + 1;
			
			$que = sprintf("SELECT roar_room FROM person WHERE id='%s'",
				mysql_real_escape_string($user_id));
			$re = mysql_query($que, $connect);
			$result = mysql_fetch_row($re);
			
			$str = '';
			$getNumber = -1;
			if($result[0] != '0'){
				$try1 = split(';', $result[0]);
				$try2 = array();
				$count = count($try1);
		
				for($i = 0; $i < $count; ++$i){
					$try2[$i] = split('/',  $try1[$i]);
					
					// Check if there is same writing_num to show with this writing_num
					if($writing_num == $try2[$i][1]){
						$extraString = $theme.'/'.$writing_num.'/'.$date.'/'.'0'.'/'.'0'.'/'.'2';
						$getNumber = $i;
					}
					else{
						if($str == '')
							$str = $try2[$i][0].'/'.$try2[$i][1].'/'.$try2[$i][2].'/'.'0'.'/'.'0'.'/'.'2';
						else
							$str .= ';'.$try2[$i][0].'/'.$try2[$i][1].'/'.$try2[$i][2].'/'.'0'.'/'.'0'.'/'.'2';
					}
				}
				
				// If there is same writing_num to show with this writing_num, brign it to the front
				if($getNumber != -1){
					if($count == 1)
						$str = $extraString;
					else{
						$str .= ';'.$extraString;
					}
				}
				else{
					$str .= ';'.$theme.'/'.$writing_num.'/'.$date.'/'.'0'.'/'.'0'.'/'.'2';
				}
			}
			else{
				$str = $theme.'/'.$writing_num.'/'.$date.'/'.'0'.'/'.'0'.'/'.'2';
			}
			
			if($getNumber == -1){
				$que = sprintf("update person set r_num=r_num+1, roar_room='%s' where id='%s'",
							mysql_real_escape_string($str),
							mysql_real_escape_string($user_id));
			}
			else{
				$que = sprintf("update person set roar_room='%s' where id='%s'",
							mysql_real_escape_string($str),
							mysql_real_escape_string($user_id));
			}

			mysql_query($que, $connect);
		}
		else{
			if($row[0] >= $milli_second * $writingToShow){
			// Get string split
			$original = getSimpleSpliterLimited($row[1], '%#$3%', ';', $splitLength, $row[0], $writingToShow, $milli_second);
			$try1 = split(';',  $original[1]);
			$try2 = array();
			$count = count($try1);
		
			for($i = 0; $i < $count; ++$i){
				$original = getSimpleSpliterLimited($try1[$i], '%3#$%', '/', $splitLength, $dataToSend, $writingToShow, 0);
				$try2[$i] = split('/',  $original[1]);
			}
			
			$count2 = count($try2[0]);
			for($i = 0; $i < $count; ++$i){
				if($i != 0){
					$str .= '%#$3%';
				}
				
				for($j = 0; $j < $count2; ++$j){
					if(($j + 1) % 5 == 2){
						$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($try2[$i][$j]));
						$re = mysql_query($que, $connect);
						$picture_data = mysql_fetch_row($re);
						$try2[$i][$j + 1] = $picture_data[0];
					}
					
					if($j == $count2 - 1){
						$str .= $try2[$i][$j];
					}
					else{
						$str .= $try2[$i][$j].'%3#$%';
					}
				}
			}
			
			$returnvars['result'] = $str;
			$returnvars['num'] = $row[0];
			}
			else{
				$returnvars['is_success'] = "false";
			}
		}
	}
}

echo json_encode($returnvars);

if($is_update == 'true' && $is_delete != 'true' && $returnvars['is_success'] == 'true'){
	$que = sprintf("SELECT reg_id FROM person where id='%s'",
						mysql_real_escape_string($row[2]));
	$re = mysql_query($que, $connect);
	$reg_id = mysql_fetch_assoc($re);
		
	$arr['registration_ids'][0] = $reg_id['reg_id'];
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
	$response = curl_exec($ch);
	echo $response;
	curl_close($ch);
}

mysql_close($connect);

// strrpos 는 역으로도 문자열 위치검색가능(다만 끝에서부터 역순으로 지정된 문자까지만 검색)
function getSimpleSpliterLimited($original, $from, $to, $length, $writingnum, $limitcount, $number){
	$replacedString = strrev($original);
	$from = strrev($from);
	$to = strrev($to);
	$lastPos = 0;
	$count = 0;
	$cut = false;
	$strCut = '';
	$contentCut = '';
	
	if($writingnum >= ($number + 1) * $limitcount)
		$pageToGet = $limitcount;
	else
		$pageToGet = $writingnum % $limitcount;
	
	for($i = 0; $i < $number * $limitcount; ++$i){
		if(strpos($replacedString, $from, $lastPos) !== false){
			$lastPos = strpos($replacedString, $from, $lastPos);
		}
		
		// 빌어먹을 1024바이트 제한을 피하기 위해 잘라서 따로 보관해 둔다
		$lastPos += $length;
		if($lastPos > 500 || $i + 1 == $number * $limitcount){
			$strCut .= substr($replacedString, 0, $lastPos);
			$replacedString = substr($replacedString, $lastPos, strlen($replacedString) - $lastPos);
			$lastPos = 0;
			$cut = true;
		}
	}
	
	
	$startPos = $lastPos;
	for($i = 0; $i < $pageToGet; ++$i){
		if(strpos($replacedString, $from, $startPos) !== false){
			$startPos = strpos($replacedString, $from, $startPos);
			
			$replacedString = substr($replacedString, $lastPos, $startPos).$to.substr($replacedString, $startPos + $length, strlen($replacedString));
			
			++$count;
		}
		
		// 빌어먹을 1024바이트 제한을 피하기 위해 잘라서 따로 보관해 둔다
		if($startPos > 500){
			$startPos += $length;
			$contentCut .= substr($replacedString, 0, $startPos);
			$replacedString = substr($replacedString, $startPos, strlen($replacedString) - $startPos);
			$startPos = 0;
			$lastPos = 0;
			$cut = true;
		}
	}
	
	if($count != $pageToGet){
		if(strpos($replacedString, $from, $startPos) !== false){
			$startPos = strpos($replacedString, $from, $startPos);
		}
		else{
			$startPos = strlen($replacedString);
		}
	}
	
	if($cut){
		$replacedString = $strCut.$contentCut.$replacedString;
		$lastPos += strlen($strCut);
		$startPos += strlen($strCut) + strlen($contentCut);
	}
	
	$result = array();
	$result[0] = strrev(substr($replacedString, 0, $lastPos));
	$result[1] = strrev(substr($replacedString, $lastPos, $startPos - $lastPos));
	$result[2] = strrev(substr($replacedString, $startPos, strlen($replacedString) - $startPos));

	return $result;
}

function getPositionOfString($writingnum, $pos , $writingToShow){
	if($pos == 0){
		return 2; // head
	}
	
	if((int) ($writingnum / $writingToShow - $pos) != 0){
		return 1; // middle
	}
	else{
		return 0; // last
	}
}
?>