<?php
$temp_location = $_POST['location'];
$temp_user_id = $_POST['userID'];
$setting_distance = $_POST['setting_distance'];
$setting_range = $_POST['setting_range'];

include "distance_setting.php";

include "connect_db.php";

$que = sprintf("update person set location='%s' where id='%s'",
				mysql_real_escape_string($temp_location),
				mysql_real_escape_string($temp_user_id));

$result = mysql_query($que, $connect);

$returnvars = array();
if(!$result){
	$returnvars['is_success'] = "false";
}
else{
	$returnvars['is_success'] = "true";
	
	if($setting_range == 1){
		// $count = mysql_num_fields($re); // 열 개수
		// $count = mysql_num_rows($re); // 행 개수
		
		$que = sprintf("SELECT location FROM person where id='%s'",
						mysql_real_escape_string($temp_user_id));						
		$re = mysql_query($que, $connect);
		$myDistance = mysql_result($re, 0, "location");
		
		$que = sprintf("SELECT isLogin, location FROM person where id!='%s'",
						mysql_real_escape_string($temp_user_id));
		$re = mysql_query($que, $connect);
		
		$num_people = 0;
		switch($setting_distance){
			case 1:
				while($row = mysql_fetch_array($re)){
					if($row['isLogin'] == 1){
						$resultDistance = getKMBetweenDistances($myDistance, $row['location']);
					
						if($resultDistance < $near){
							++$num_people;
						}
					}
				}
				break;
			case 2:
				while($row = mysql_fetch_array($re)){
					if($row['isLogin'] == 1){
						$resultDistance = getKMBetweenDistances($myDistance, $row['location']);
					
						if($resultDistance < $far){
							++$num_people;
						}
					}
				}
				break;
			case 3:
				while($row = mysql_fetch_array($re)){
					if($row['isLogin'] == 1){
						$resultDistance = getKMBetweenDistances($myDistance, $row['location']);
					
						if($resultDistance < $very_far){
							++$num_people;
						}
					}
				}
				break;
		}
		
		$returnvars['num_of_people_around_me'] = $num_people;
	}
	else if($setting_range == 2){
		$que = "SELECT num_people FROM echo_info WHERE num=1";
		$re = mysql_query($que, $connect);
		$num_people = mysql_result($re, 0, "num_people");
		$returnvars['num_of_people_around_me'] = $num_people - 1;
	}
	else{
		$returnvars['num_of_people_around_me'] = '-1';
		$returnvars['is_success'] = "false";
	}
}

echo json_encode($returnvars);
mysql_close($connect);
?>