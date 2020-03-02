<?php
include "connect_db.php";

$splitLength = 5;

$theme = $_POST['theme'];
$user_id = $_POST['user_id'];
$writing_num = $_POST['writing_num'];
$date = $_POST['date'];
$milli_second = $_POST['milli_second'];
$is_update = $_POST['is_update'];
$is_delete = $_POST['is_delete'];
$my_photo = $_POST['my_photo'];
/*
$theme = '7';
$user_id = 'shkoma';
$writing_num = '1384776442858';
$date = '2013.11.18 21:7:22';
$milli_second = '1385473556795';
$is_update = 'false';
$is_delete = 'true';
$my_photo = 'photo_1384776442858.png';
*/
switch($theme){
	case 0:
		break;
	case 1:
		$que = sprintf("SELECT join_num, joins FROM travel_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 2:
		$que = sprintf("SELECT join_num, joins FROM exercise_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 3:
		$que = sprintf("SELECT join_num, joins FROM hobby_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 4:
		$que = sprintf("SELECT join_num, joins FROM study_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 5:
		break;
	case 6:
		$que = sprintf("SELECT join_num, joins FROM work_table WHERE writing_num='%s'",
				mysql_real_escape_string($writing_num));
		break;
	case 7:
		$que = sprintf("SELECT join_num, joins FROM sellby_table WHERE writing_num='%s'",
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
	
	if($is_delete == 'true'){
		$original = getSimpleSpliter($row[1], '%#$3%', ';', $splitLength);
		$try1 = split(';',  $original);
		$try2 = array();
		$count = count($try1);
		
		$getNumber = -1;
		for($i = 0; $i < $count; ++$i){
			$original = getSimpleSpliter($try1[$i], '%3#$%', '/', $splitLength);
			$try2[$i] = split('/',  $original);
			
			if($milli_second == $try2[$i][0]){
				$getNumber = $i;
			}
		}
		
		$str;
		if($getNumber != -1){
		$count2 = count($try2[0]);
		for($i = 0; $i < $count; ++$i){
			if($i != $getNumber){
				if($getNumber == 0){
					if($i > 1)
						$str .= '%#$3%';
				}
				else{
					if($i != 0)
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
		}
		
			switch($theme){
			case 0:
				break;
			case 1:
				$que = sprintf("update travel_table set join_num=join_num-1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 2:
				$que = sprintf("update exercise_table set join_num=join_num-1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 3:
				$que = sprintf("update hobby_table set join_num=join_num-1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 4:
				$que = sprintf("update study_table set join_num=join_num-1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 5:
				break;
			case 6:
				$que = sprintf("update work_table set join_num=join_num-1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			case 7:
				$que = sprintf("update sellby_table set join_num=join_num-1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($str),
				mysql_real_escape_string($writing_num));
				break;
			}
			mysql_query($que, $connect);
			$returnvars['result'] = $str;
			$returnvars['num'] = $row[0] - 1;
			
			$que = sprintf("SELECT roar_room FROM person WHERE id='%s'",
				mysql_real_escape_string($user_id));
			$re = mysql_query($que, $connect);
			$result = mysql_fetch_row($re);
			
			$getNumber = -1;
			if($result[0] == '0')
				$str = $theme.'/'.$writing_num.'/'.$date.'/'.'0'.'/'.'0'.'/'.'1';
			else{
				$try1 = split(';', $result[0]);
				$try2 = array();
				$count = count($try1);
		
				$getNumber = -1;
				for($i = 0; $i < $count; ++$i){
					$try2[$i] = split('/',  $try1[$i]);
			
					if($writing_num == $try2[$i][1]){
						$getNumber = 0;
					}
					else{
						$str = $result[0].';'.$theme.'/'.$writing_num.'/'.$date.'/'.'0'.'/'.'0'.'/'.'1';
					}
				}
			}
			
			if($getNumber != 0){
			$que = sprintf("update person set r_num=r_num+1, roar_room='%s' where id='%s'",
							mysql_real_escape_string($str),
							mysql_real_escape_string($user_id));

			mysql_query($que, $connect);
			}
		}
		else{
			$returnvars['is_success'] = "false";
		}
	}
	else{
		if($is_update == 'true'){
			if($row[0] == 0){
				$str = $milli_second.'%3#$%'.$user_id.'%3#$%'.$my_photo.'%3#$%'.$date;
			}else{
				$str = $row[1].'%#$3%'.$milli_second.'%3#$%'.$user_id.'%3#$%'.$my_photo.'%3#$%'.$date;
			}
			
			// Get string split
			$original = getSimpleSpliter($str, '%#$3%', ';', $splitLength);
			$try1 = split(';',  $original);
			$try2 = array();
			$count = count($try1);
		
			$getNumber = -1;
			for($i = 0; $i < $count; ++$i){
				$original = getSimpleSpliter($try1[$i], '%3#$%', '/', $splitLength);
				$try2[$i] = split('/',  $original);
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
				break;
			case 1:
				$que = sprintf("update travel_table set join_num=join_num+1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 2:
				$que = sprintf("update exercise_table set join_num=join_num+1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 3:
				$que = sprintf("update hobby_table set join_num=join_num+1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 4:
				$que = sprintf("update study_table set join_num=join_num+1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 5:
				break;
			case 6:
				$que = sprintf("update work_table set join_num=join_num+1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
				mysql_real_escape_string($writing_num));
				break;
			case 7:
				$que = sprintf("update sellby_table set join_num=join_num+1, joins='%s' where writing_num='%s'",
				mysql_real_escape_string($wr),
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
						$extraString = $theme.'/'.$writing_num.'/'.$date.'/'.'0'.'/'.'0'.'/'.'1';
						$getNumber = $i;
					}
					else{
						if($str == '')
							$str = $try2[$i][0].'/'.$try2[$i][1].'/'.$try2[$i][2].'/'.'0'.'/'.'0'.'/'.'1';
						else
							$str .= ';'.$try2[$i][0].'/'.$try2[$i][1].'/'.$try2[$i][2].'/'.'0'.'/'.'0'.'/'.'1';
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
					$str .= ';'.$theme.'/'.$writing_num.'/'.$date.'/'.'0'.'/'.'0'.'/'.'1';
				}
			}
			else{
				$str = $theme.'/'.$writing_num.'/'.$date.'/'.'0'.'/'.'0'.'/'.'1';
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
			// Get string split
			$original = getSimpleSpliter($row[1], '%#$3%', ';', $splitLength);
			$try1 = split(';',  $original);
			$try2 = array();
			$count = count($try1);
		
			for($i = 0; $i < $count; ++$i){
				$original = getSimpleSpliter($try1[$i], '%3#$%', '/', $splitLength);
				$try2[$i] = split('/',  $original);
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
	}
}

// DB에서 쓰는 명령어를 변수명으로 지정하면 문제가 크다.
echo json_encode($returnvars);

mysql_close($connect);

function getSimpleSpliter($original, $from, $to, $length){
	$replacedString = $original;
	
	while(strpos($replacedString, $from, 0) !== false){
		$startPos = strpos($replacedString, $from, 0);
		$replacedString = substr($replacedString, 0, $startPos).$to.substr($replacedString, $startPos + $length, strlen($original) - 1);
	}
	
	return $replacedString;
}
?>