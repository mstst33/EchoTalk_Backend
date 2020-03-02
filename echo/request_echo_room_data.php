<?php
include "connect_db.php";

$splitLength = 1;
$writingToShow = 10;

$is_favorite = $_POST['is_favorite']; // false: echo_room, true: roar_room
$is_delete = $_POST['is_delete'];
$user_id = $_POST['user_id'];
$theme = $_POST['theme']; // delete
$writing_nums = $_POST['writing_num']; // when delete, writing_num. when echo or roar room, pagenum
/*
$is_favorite = 'true';
$is_delete = 'false';
$user_id = 'shkoma';
$theme = '0';
$writing_nums = '0';
*/
$returnvars = array();
$returnvars['result'] = array();
$returnvars['is_success'] = false;

if($is_delete == 'true'){
	// 테이블에서 글 삭제
	switch($theme){
	case 0:
		$que = sprintf("DELETE from normal_table where writing_num='%s'",
						mysql_real_escape_string($writing_nums));
		break;
	case 1:
		$que = sprintf("DELETE from travel_table where writing_num='%s'",
						mysql_real_escape_string($writing_nums));
		break;
	case 2:
		$que = sprintf("DELETE from exercise_table where writing_num='%s'",
						mysql_real_escape_string($writing_nums));
		break;
	case 3:
		$que = sprintf("DELETE from hobby_table where writing_num='%s'",
						mysql_real_escape_string($writing_nums));
		break;
	case 4:
		$que = sprintf("DELETE from study_table where writing_num='%s'",
						mysql_real_escape_string($writing_nums));
		break;
	case 5:
		$que = sprintf("DELETE from question_table where writing_num='%s'",
						mysql_real_escape_string($writing_nums));
		break;
	case 6:
		$que = sprintf("DELETE from work_table where writing_num='%s'",
						mysql_real_escape_string($writing_nums));
		break;
	case 7:
		$que = sprintf("DELETE from sellby_table where writing_num='%s'",
						mysql_real_escape_string($writing_nums));
		break;
	}
	mysql_query($que, $connect);
	
	// 개인 echo_room에서 삭제
	$que = sprintf("SELECT echo_room FROM person WHERE id='%s'",
				mysql_real_escape_string($user_id));
	$re = mysql_query($que, $connect);
	$result = mysql_fetch_row($re);
			
	$getNumber = -1;
	if($result[0] != '0'){
		$try1= split(';', $result[0]);;
		$try2 = array();
		$count = count($try1);
		
		for($i = 0; $i < $count; ++$i){
			$try2[$i] = split('/',  $try1[$i]);
			
			if($writing_nums == $try2[$i][1]){
				$getNumber = $i;
			}
		}
	}
	
	if($getNumber != -1){
		$count2 = count($try2[0]);
		for($i = 0; $i < $count; ++$i){
			if($i != $getNumber){
				if($getNumber == 0){
					if($i > 1)
						$str .= ';';
				}
				else{
					if($i != 0)
						$str .= ';';
				}
				for($j = 0; $j < $count2; ++$j){
					if($j == $count2 - 1){
						$str .= $try2[$i][$j];
					}
					else{
						$str .= $try2[$i][$j].'/';
					}	
				}
			}
		}
		
		$que = sprintf("update person set e_num=e_num-1, echo_room='%s' where id='%s'",
						mysql_real_escape_string($str),
						mysql_real_escape_string($user_id));

		mysql_query($que, $connect);
		/*
		if($count - 1 != '0'){
			$original = getStringsLimited($str, ';', $splitLength, $count - 1, $writingToShow, $writing_nums); // replace pagenum!!
			$try1 = split(';', $original);
			$try2 = array();
			$count = count($try1);
			
			$writing_num = 0;
			$writing = array();
			for($i = $count - 1; $i >= 0; --$i){
				$try2[$i] = split('/',  $try1[$i]);
				
				switch($try2[$i][0]){
				case 0:
					$que = sprintf("SELECT * FROM normal_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 1:
					$que = sprintf("SELECT * FROM travel_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 2:
					$que = sprintf("SELECT * FROM exercise_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 3:
					$que = sprintf("SELECT * FROM hobby_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 4:
					$que = sprintf("SELECT * FROM study_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 5:
					$que = sprintf("SELECT * FROM question_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 6:
					$que = sprintf("SELECT * FROM work_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 7:
					$que = sprintf("SELECT * FROM sellby_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				}
				
				$re = mysql_query($que, $connect);
				$othercount = mysql_num_fields($re);
				while($row = mysql_fetch_row($re)){						
					switch($try2[$i][0]){
					case 0:
						$writing[$writing_num] = '0%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[5]));
						break;
					case 1:
						$writing[$writing_num] = '1%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 2:
						$writing[$writing_num] = '2%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 3:
						$writing[$writing_num] = '3%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 4:
						$writing[$writing_num] = '4%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[11]));
						break;
					case 5:
						$writing[$writing_num] = '5%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[7]));
						break;
					case 6:
						$writing[$writing_num] = '6%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[12]));
						break;
					case 7:
						$writing[$writing_num] = '7%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[11]));
						break;
					}

					$ret = mysql_query($que, $connect);
					$picture_data = mysql_fetch_row($ret);
					$writing[$writing_num] .= $picture_data[0];
					++$writing_num;
				}
			}
			
			$returnvars['return_num'] = $writing_num;
			$returnvars['result'] = $writing;
			$returnvars['is_success'] = true;
		}*/
		$returnvars['is_success'] = true;
	}
}
else{
	if($is_favorite == 'false'){
		// echo_room에서 데이타를 읽어옴
		$que = sprintf("SELECT e_num, echo_room FROM person WHERE id='%s'",
				mysql_real_escape_string($user_id));
		$re = mysql_query($que, $connect);
		$echo_room = mysql_fetch_row($re);
		
		if($echo_room[1] != '0'){
			$original = getStringsLimited($echo_room[1], ';', $splitLength, $echo_room[0], $writingToShow, $writing_nums);
			$try1 = split(';',  $original);
			$try2 = array();
			$count = count($try1);
			
			$check_num = 0;
			$final_str = array();
			$writing_num = 0;
			$writing = array();
			for($i = $count - 1; $i >= 0; --$i){
				$try2[$i] = split('/',  $try1[$i]);
				
				switch($try2[$i][0]){
				case 0:
					$que = sprintf("SELECT * FROM normal_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 1:
					$que = sprintf("SELECT * FROM travel_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 2:
					$que = sprintf("SELECT * FROM exercise_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 3:
					$que = sprintf("SELECT * FROM hobby_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 4:
					$que = sprintf("SELECT * FROM study_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 5:
					$que = sprintf("SELECT * FROM question_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 6:
					$que = sprintf("SELECT * FROM work_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 7:
					$que = sprintf("SELECT * FROM sellby_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				}
				
				$re = mysql_query($que, $connect);
				
				if($re){ // 해당 글이 존재할 때
				$othercount = mysql_num_fields($re);
				$final_str[$check_num] = $try1[$i];
				++$check_num;
				
				while($row = mysql_fetch_row($re)){						
					switch($try2[$i][0]){
					case 0:
						$writing[$writing_num] = '0%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[5]));
						break;
					case 1:
						$writing[$writing_num] = '1%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 2:
						$writing[$writing_num] = '2%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 3:
						$writing[$writing_num] = '3%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 4:
						$writing[$writing_num] = '4%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[11]));
						break;
					case 5:
						$writing[$writing_num] = '5%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[7]));
						break;
					case 6:
						$writing[$writing_num] = '6%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[12]));
						break;
					case 7:
						$writing[$writing_num] = '7%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[11]));
						break;
					}

					$ret = mysql_query($que, $connect);
					$picture_data = mysql_fetch_row($ret);
					$writing[$writing_num] .= $picture_data[0];
					++$writing_num;
				}
				}
			}
			
			if($check_num != 0){
				// 뒤집기
				for($i = 0; $i < (int)($check_num / 2); ++$i){
					$temp = $final_str[$check_num - $i - 1];
					$final_str[$check_num - $i - 1] = $final_str[$i];
					$final_str[$i] = $temp;
				}
				
				for($i = 0; $i < $check_num; ++$i){
					if($i == 0){
						$str = $final_str[$i];
					}
					else{
						$str .= ';'.$final_str[$i];
					}
				}
				
				$que = sprintf("update person set echo_room='%s' where id='%s'",
						mysql_real_escape_string($str),
						mysql_real_escape_string($user_id));

				mysql_query($que, $connect);
			}
			
			$returnvars['return_num'] = $writing_num;
			$returnvars['result'] = $writing;
			$returnvars['is_success'] = true;
		}
	}
	else{
		// roar_room에서 데이타를 읽어옴
		$que = sprintf("SELECT r_num, roar_room FROM person WHERE id='%s'",
				mysql_real_escape_string($user_id));
		$re = mysql_query($que, $connect);
		$roar_room = mysql_fetch_row($re);
		
		if($roar_room[1] != '0'){
			$original = getStringsLimited($roar_room[1], ';', $splitLength, $roar_room[0], $writingToShow, $writing_nums);
			$try1 = split(';',  $original);
			$try2 = array();
			$count = count($try1);
			
			$check_num = 0;
			$final_str = array();
			$writing_num = 0;
			$writing = array();
			for($i = $count - 1; $i >= 0; --$i){
				$try2[$i] = split('/',  $try1[$i]);
				
				switch($try2[$i][0]){
				case 0:
					$que = sprintf("SELECT * FROM normal_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 1:
					$que = sprintf("SELECT * FROM travel_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 2:
					$que = sprintf("SELECT * FROM exercise_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 3:
					$que = sprintf("SELECT * FROM hobby_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 4:
					$que = sprintf("SELECT * FROM study_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 5:
					$que = sprintf("SELECT * FROM question_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 6:
					$que = sprintf("SELECT * FROM work_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				case 7:
					$que = sprintf("SELECT * FROM sellby_table where writing_num='%s'",
							mysql_real_escape_string($try2[$i][1]));
					break;
				}
				
				$re = mysql_query($que, $connect);
				
				if($re){ // 해당 글이 존재할 때
				$othercount = mysql_num_fields($re);
				$final_str[$check_num] = $try1[$i];
				++$check_num;
				
				while($row = mysql_fetch_row($re)){				
					switch($try2[$i][0]){
					case 0:
						$writing[$writing_num] = '0%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[5]));
						break;
					case 1:
						$writing[$writing_num] = '1%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 2:
						$writing[$writing_num] = '2%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 3:
						$writing[$writing_num] = '3%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[10]));
						break;
					case 4:
						$writing[$writing_num] = '4%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[11]));
						break;
					case 5:
						$writing[$writing_num] = '5%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[7]));
						break;
					case 6:
						$writing[$writing_num] = '6%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[12]));
						break;
					case 7:
						$writing[$writing_num] = '7%$3#%';
								
						for($j = 0; $j < $othercount; ++$j){
							$writing[$writing_num] .= $row[$j].'%$3#%';
						}
						
						$que = sprintf("SELECT picture_data FROM person where id='%s'",
							mysql_real_escape_string($row[11]));
						break;
					}

					$ret = mysql_query($que, $connect);
					$picture_data = mysql_fetch_row($ret);
					$writing[$writing_num] .= $picture_data[0];
					++$writing_num;
				}
				}
			}
			
			if($check_num != 0){
				// 뒤집기
				for($i = 0; $i < (int)($check_num / 2); ++$i){
					$temp = $final_str[$check_num - $i - 1];
					$final_str[$check_num - $i - 1] = $final_str[$i];
					$final_str[$i] = $temp;
				}
				
				for($i = 0; $i < $check_num; ++$i){
					if($i == 0){
						$str = $final_str[$i];
					}
					else{
						$str .= ';'.$final_str[$i];
					}
				}
				
				$que = sprintf("update person set roar_room='%s' where id='%s'",
						mysql_real_escape_string($str),
						mysql_real_escape_string($user_id));

				mysql_query($que, $connect);
			}
			
			$returnvars['return_num'] = $writing_num;
			$returnvars['result'] = $writing;
			$returnvars['is_success'] = true;
		}
	}
}

echo json_encode($returnvars);
mysql_close($connect);

function getStringsLimited($original, $split, $length, $writingnum, $limitcount, $number){
	$replacedString = strrev($original);
	$lastPos = 0;
	$count = 0;
	
	
	
	if($writingnum >= ($number + 1) * $limitcount)
		$pageToGet = $limitcount;
	else
		$pageToGet = $writingnum % $limitcount;
	
	for($i = 0; $i < $number * $limitcount; ++$i){
		if(strpos($replacedString, $split, $lastPos) !== false){
			$lastPos = strpos($replacedString, $split, $lastPos);
		}
		
		$lastPos += $length;
		if($lastPos > 500 || $i + 1 == $number * $limitcount){
			$replacedString = substr($replacedString, $lastPos, strlen($replacedString) - $lastPos);
			$lastPos = 0;
		}
	}
	
	$startPos = $lastPos;
	for($i = 0; $i < $pageToGet; ++$i){
		if(strpos($replacedString, $split, $startPos) !== false){
			$startPos = strpos($replacedString, $split, $startPos);
			$startPos += $length;
			
			++$count;
		}
	}
	
	if($count != $pageToGet){
		if(strpos($replacedString, $split, $startPos) !== false){
			$startPos = strpos($replacedString, $split, $startPos);
		}
		else{
			$startPos = strlen($replacedString);
		}
	}
	
	$replacedString = strrev(substr($replacedString, $lastPos, $startPos - $lastPos));
	
	return $replacedString;
}
?>