<?php
include "connect_db.php";
include "distance_setting.php";

$is_first = $_POST['is_first'];
$theme = $_POST['theme'];
$userid = $_POST['user_id'];
$setting_distance = $_POST['setting_distance'];
$setting_range = $_POST['setting_range'];
/*
$is_first = 'true';
$theme = '10000000';
$userid = 'mstst';
$setting_distance = '1';
$setting_range = '2';
*/
if($is_first == 'false'){
	$last_writing_num = $_POST['last_writing_num'];
}

$que = sprintf("update person set interested_theme='%s' where id='%s'",
				mysql_real_escape_string($theme),
				mysql_real_escape_string($userid));
				
mysql_query($que, $connect);

$que = sprintf("SELECT location FROM person where id='%s'",
						mysql_real_escape_string($userid));
$re = mysql_query($que, $connect);
$result = mysql_fetch_row($re);
$location = $result[0];
// $location = '37.3303286 127.2438397';

$returnvars = array();
$returnvars['result'] = array();
if($location == '' || $location == '-1.0 -1.0'){
	$returnvars['is_success'] = false;
}
else{
	$returnvars['is_success'] = true;
	
	// 각 테이블 별로 쿼리 만들기
	if($theme{0} == 1){
		if($is_first == 'true'){
			$que = "SELECT * FROM normal_table ORDER BY writing_num DESC";
		}
		else{
			$que = sprintf("SELECT * FROM normal_table where writing_num<'%s' ORDER BY writing_num DESC", mysql_real_escape_string($last_writing_num));
		}
		$re0 = mysql_query($que, $connect);
		$count0 = mysql_num_fields($re0);
	}
	
	if($theme{1} == 1){
		if($is_first == 'true'){
			$que = "SELECT * FROM travel_table ORDER BY writing_num DESC";
		}
		else{
			$que = sprintf("SELECT * FROM travel_table where writing_num<'%s' ORDER BY writing_num DESC", mysql_real_escape_string($last_writing_num));
		}
		$re1 = mysql_query($que, $connect);
		$count1 = mysql_num_fields($re1);
	}
	
	if($theme{2} == 1){
		if($is_first == 'true'){
			$que = "SELECT * FROM exercise_table ORDER BY writing_num DESC";
		}
		else{
			$que = sprintf("SELECT * FROM exercise_table where writing_num<'%s' ORDER BY writing_num DESC", mysql_real_escape_string($last_writing_num));
		}
		$re2 = mysql_query($que, $connect);
		$count2 = mysql_num_fields($re2);
	}
	
	
	if($theme{3} == 1){
		if($is_first == 'true'){
			$que = "SELECT * FROM hobby_table ORDER BY writing_num DESC";
		}
		else{
			$que = sprintf("SELECT * FROM hobby_table where writing_num<'%s' ORDER BY writing_num DESC", mysql_real_escape_string($last_writing_num));
		}
		$re3 = mysql_query($que, $connect);
		$count3 = mysql_num_fields($re3);
	}
	
	if($theme{4} == 1){
		if($is_first == 'true'){
			$que = "SELECT * FROM study_table ORDER BY writing_num DESC";
		}
		else{
			$que = sprintf("SELECT * FROM study_table where writing_num<'%s' ORDER BY writing_num DESC", mysql_real_escape_string($last_writing_num));
		}
		$re4 = mysql_query($que, $connect);
		$count4 = mysql_num_fields($re4);
	}
	
	if($theme{5} == 1){
		if($is_first == 'true'){
			$que = "SELECT * FROM question_table ORDER BY writing_num DESC";
		}
		else{
			$que = sprintf("SELECT * FROM question_table where writing_num<'%s' ORDER BY writing_num DESC", mysql_real_escape_string($last_writing_num));
		}
		$re5 = mysql_query($que, $connect);
		$count5 = mysql_num_fields($re5);
	}
	
	if($theme{6} == 1){
		if($is_first == 'true'){
			$que = "SELECT * FROM work_table ORDER BY writing_num DESC";
		}
		else{
			$que = sprintf("SELECT * FROM work_table where writing_num<'%s' ORDER BY writing_num DESC", mysql_real_escape_string($last_writing_num));
		}
		$re6 = mysql_query($que, $connect);
		$count6 = mysql_num_fields($re6);
	}
	
	if($theme{7} == 1){
		if($is_first == 'true'){
			$que = "SELECT * FROM sellby_table ORDER BY writing_num DESC";
		}
		else{
			$que = sprintf("SELECT * FROM sellby_table where writing_num<'%s' ORDER BY writing_num DESC", mysql_real_escape_string($last_writing_num));
		}
		$re7 = mysql_query($que, $connect);
		$count7 = mysql_num_fields($re7);
	}
	$writing_split = array(); // 구분자(writing_num)
	$writing = array();
	$writing_num = 0;
	$limit_num = 0;
	
	// 자신의 위치를 기준으로 설정한 거리에 있는 글들 중 최신 글을 10개 읽어온다
	// 내림차순 정렬로 하면 맨 끝에 있는 행 부터 읽어온다(DESC)
	// 비교 연산자는 반드시 스트링이어야 비교가 가능하다
	if($setting_range == 1){
		$re = mysql_query($que, $connect);
		
		switch($setting_distance){
			case 1:
					if($theme{0} == 1){
						while($row = mysql_fetch_row($re0)){
							$resultDistance = getKMBetweenDistances($location, $row[3]);
							
							if($resultDistance < $near){
								$writing[$writing_num] = '0%$3#%';
								$writing_split[$writing_num] = $row[4];
								
								for($i = 0; $i < $count0; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[5]));
								$re = mysql_query($que, $connect);
								$picture_data = mysql_fetch_row($re);
								$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{1} == 1){
						while($row = mysql_fetch_row($re1)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $near){
								$writing[$writing_num] = '1%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count1; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{2} == 1){
						while($row = mysql_fetch_row($re2)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $near){
								$writing[$writing_num] = '2%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count2; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
	
					if($theme{3} == 1){
						while($row = mysql_fetch_row($re3)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $near){
								$writing[$writing_num] = '3%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count3; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{4} == 1){
						while($row = mysql_fetch_row($re4)){
							$resultDistance = getKMBetweenDistances($location, $row[9]);
							
							if($resultDistance < $near){
								$writing[$writing_num] = '4%$3#%';
								$writing_split[$writing_num] = $row[10];
								for($i = 0; $i < $count4; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[11]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{5} == 1){
						while($row = mysql_fetch_row($re5)){
							$resultDistance = getKMBetweenDistances($location, $row[5]);
							
							if($resultDistance < $near){
								$writing[$writing_num] = '5%$3#%';
								$writing_split[$writing_num] = $row[6];
								for($i = 0; $i < $count5; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[7]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{6} == 1){
						while($row = mysql_fetch_row($re6)){
							$resultDistance = getKMBetweenDistances($location, $row[10]);
							
							if($resultDistance < $near){
								$writing[$writing_num] = '6%$3#%';
								$writing_split[$writing_num] = $row[11];
								for($i = 0; $i < $count6; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[12]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{7} == 1){
						while($row = mysql_fetch_row($re7)){
							$resultDistance = getKMBetweenDistances($location, $row[9]);
							
							if($resultDistance < $near){
								$writing[$writing_num] = '7%$3#%';
								$writing_split[$writing_num] = $row[10];
								for($i = 0; $i < $count7; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[11]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
				break;
			case 2:
				if($theme{0} == 1){
						while($row = mysql_fetch_row($re0)){
							$resultDistance = getKMBetweenDistances($location, $row[3]);
							
							if($resultDistance < $far){
								$writing[$writing_num] = '0%$3#%';
								$writing_split[$writing_num] = $row[4];
								for($i = 0; $i < $count0; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[5]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{1} == 1){
						while($row = mysql_fetch_row($re1)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $far){
								$writing[$writing_num] = '1%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count1; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{2} == 1){
						while($row = mysql_fetch_row($re2)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $far){
								$writing[$writing_num] = '2%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count2; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
	
					if($theme{3} == 1){
						while($row = mysql_fetch_row($re3)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $far){
								$writing[$writing_num] = '3%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count3; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{4} == 1){
						while($row = mysql_fetch_row($re4)){
							$resultDistance = getKMBetweenDistances($location, $row[9]);
							
							if($resultDistance < $far){
								$writing[$writing_num] = '4%$3#%';
								$writing_split[$writing_num] = $row[10];
								for($i = 0; $i < $count4; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[11]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{5} == 1){
						while($row = mysql_fetch_row($re5)){
							$resultDistance = getKMBetweenDistances($location, $row[5]);
							
							if($resultDistance < $far){
								$writing[$writing_num] = '5%$3#%';
								$writing_split[$writing_num] = $row[6];
								for($i = 0; $i < $count5; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[7]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{6} == 1){
						while($row = mysql_fetch_row($re6)){
							$resultDistance = getKMBetweenDistances($location, $row[10]);
							
							if($resultDistance < $far){
								$writing[$writing_num] = '6%$3#%';
								$writing_split[$writing_num] = $row[11];
								for($i = 0; $i < $count6; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[12]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{7} == 1){
						while($row = mysql_fetch_row($re7)){
							$resultDistance = getKMBetweenDistances($location, $row[9]);
							
							if($resultDistance < $far){
								$writing[$writing_num] = '7%$3#%';
								$writing_split[$writing_num] = $row[10];
								for($i = 0; $i < $count7; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[11]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
				break;
			case 3:
				if($theme{0} == 1){
						while($row = mysql_fetch_row($re0)){
							$resultDistance = getKMBetweenDistances($location, $row[3]);
							
							if($resultDistance < $very_far){
								$writing[$writing_num] = '0%$3#%';
								$writing_split[$writing_num] = $row[4];
								for($i = 0; $i < $count0; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[5]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{1} == 1){
						while($row = mysql_fetch_row($re1)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $very_far){
								$writing[$writing_num] = '1%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count1; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{2} == 1){
						while($row = mysql_fetch_row($re2)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $very_far){
								$writing[$writing_num] = '2%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count2; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
	
					if($theme{3} == 1){
						while($row = mysql_fetch_row($re3)){
							$resultDistance = getKMBetweenDistances($location, $row[8]);
							
							if($resultDistance < $very_far){
								$writing[$writing_num] = '3%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count3; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{4} == 1){
						while($row = mysql_fetch_row($re4)){
							$resultDistance = getKMBetweenDistances($location, $row[9]);
							
							if($resultDistance < $very_far){
								$writing[$writing_num] = '4%$3#%';
								$writing_split[$writing_num] = $row[10];
								for($i = 0; $i < $count4; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[11]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{5} == 1){
						while($row = mysql_fetch_row($re5)){
							$resultDistance = getKMBetweenDistances($location, $row[5]);
							
							if($resultDistance < $very_far){
								$writing[$writing_num] = '5%$3#%';
								$writing_split[$writing_num] = $row[6];
								for($i = 0; $i < $count5; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[7]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{6} == 1){
						while($row = mysql_fetch_row($re6)){
							$resultDistance = getKMBetweenDistances($location, $row[10]);
							
							if($resultDistance < $very_far){
								$writing[$writing_num] = '6%$3#%';
								$writing_split[$writing_num] = $row[11];
								for($i = 0; $i < $count6; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[12]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{7} == 1){
						while($row = mysql_fetch_row($re7)){
							$resultDistance = getKMBetweenDistances($location, $row[9]);
							
							if($resultDistance < $very_far){
								$writing[$writing_num] = '7%$3#%';
								$writing_split[$writing_num] = $row[10];
								for($i = 0; $i < $count7; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[11]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							}
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
				break;
		}
		
		
		$writing = quickSortDESC($writing, $writing_split);
		
		if($writing_num > 10)
			$return_num = 10;
		else
			$return_num = $writing_num;
		
		if($writing_num > 10){
			for($i = $writing_num - 1; $i >= 10; --$i){
				unset($writing[$i]);
			}
		}
		
		$returnvars['return_num'] = $return_num;
		$returnvars['result'] = $writing;
	}
	else if($setting_range == 2){
					if($theme{0} == 1){
						while($row = mysql_fetch_row($re0)){
								$writing[$writing_num] = '0%$3#%';
								$writing_split[$writing_num] = $row[4];
								for($i = 0; $i < $count0; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[5]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{1} == 1){
						while($row = mysql_fetch_row($re1)){
								$writing[$writing_num] = '1%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count1; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						$limit_num = 0;
					}
	
					if($theme{2} == 1){
						while($row = mysql_fetch_row($re2)){
								$writing[$writing_num] = '2%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count2; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
	
					if($theme{3} == 1){
						while($row = mysql_fetch_row($re3)){
								$writing[$writing_num] = '3%$3#%';
								$writing_split[$writing_num] = $row[9];
								for($i = 0; $i < $count3; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[10]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{4} == 1){
						while($row = mysql_fetch_row($re4)){
								$writing[$writing_num] = '4%$3#%';
								$writing_split[$writing_num] = $row[10];
								for($i = 0; $i < $count4; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[11]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{5} == 1){
						while($row = mysql_fetch_row($re5)){
								$writing[$writing_num] = '5%$3#%';
								$writing_split[$writing_num] = $row[6];
								for($i = 0; $i < $count5; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[7]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{6} == 1){
						while($row = mysql_fetch_row($re6)){
								$writing[$writing_num] = '6%$3#%';
								$writing_split[$writing_num] = $row[11];
								for($i = 0; $i < $count6; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[12]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
	
					if($theme{7} == 1){
						while($row = mysql_fetch_row($re7)){
								$writing[$writing_num] = '7%$3#%';
								$writing_split[$writing_num] = $row[10];
								for($i = 0; $i < $count7; ++$i){
									$writing[$writing_num] .= $row[$i].'%$3#%';
								}
								
								$que = sprintf("SELECT picture_data FROM person where id='%s'", mysql_real_escape_string($row[11]));
								$re = mysql_query($que, $connect);
$picture_data = mysql_fetch_row($re);
$writing[$writing_num] .= $picture_data[0];
								++$writing_num;
								++$limit_num;
							
							if($limit_num > 9){
								$limit_num = 0;
								break;
							}
						}
						
						$limit_num = 0;
					}
					
			
			$writing = quickSortDESC($writing, $writing_split);
			
			if($writing_num > 10)
				$return_num = 10;
			else
				$return_num = $writing_num;
			
			if($writing_num > 10){
				for($i = $writing_num - 1; $i >= 10; --$i){
					unset($writing[$i]);
				}
			}
			
			$returnvars['return_num'] = $return_num;
			$returnvars['result'] = $writing;
	}
}

// 오름차순 퀵 소트
function quicksortASC($seq, $split) {
    if(!count($seq)) return $seq;
    $pivot= $seq[0];
	$pivot_split = $split[0];
    $low = $high = $low_split = $high_split = array();
    $length = count($seq);
    for($i=1; $i < $length; $i++) {
        if($split[$i] <= $pivot_split) {
            $low [] = $seq[$i];
			$low_split [] = $split[$i];
        } else {
            $high[] = $seq[$i];
			$high_split [] = $split[$i];
        }
    }
    return array_merge(quicksortASC($low, $low_split), array($pivot), quicksortASC($high, $high_split));
}

// 내림차순 퀵 소트
function quicksortDESC($seq, $split) {
    if(!count($seq)) return $seq;
    $pivot= $seq[0];
	$pivot_split = $split[0];
    $low = $high = $low_split = $high_split = array();
    $length = count($seq);
    for($i=1; $i < $length; $i++) {
        if($split[$i] <= $pivot_split) {
            $low [] = $seq[$i];
			$low_split [] = $split[$i];
        } else {
            $high[] = $seq[$i];
			$high_split [] = $split[$i];
        }
    }
    return array_merge(quicksortDESC($high, $high_split), array($pivot), quicksortDESC($low, $low_split));
}

// php 스플릿은 "php%$3#%db" 이런식으로는 스플릿은 안된다. 'php'.'%$3#%'.'db' 이런식으로 해야 스플릿이 가능하다
// 자바에서 스플릿은 뒤에 자료가 없을 경우 구분자가 있다 해도 무시해서 공간을 할당하지 아니한다.
echo json_encode($returnvars);
mysql_close($connect);
?>