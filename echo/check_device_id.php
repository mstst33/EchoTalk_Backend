<?php
include "connect_db.php";

$device_id = $_POST['device_id'];
$date = $_POST['date'];

$que = sprintf("SELECT deviceID, isLogin, id, name, gender, age, interested_theme, picture_data, email, comment, join_date FROM person WHERE deviceID='%s'",
				mysql_real_escape_string($device_id));
				
$re = mysql_query($que, $connect);
$returnvars = array();

if(!$re){
	$returnvars['is_success'] = "false";
	
	// die('Invalid query: '.mysql_error());
}
else{
	$row = mysql_fetch_row($re);
	
	// 원래 0 이여야 가능한데 앱 삭제전 0으로 만들 방법은 없을까?
	if($row[0] == $device_id && $row[1] == 1){
		$returnvars['is_success'] = "true";
		$returnvars['id'] = $row[2];
		$returnvars['name'] = $row[3];
		$returnvars['gender'] = $row[4];
		$returnvars['age'] = $row[5];
		$returnvars['interested_theme'] = $row[6];
		$returnvars['picture_data'] = $row[7];
		$returnvars['email'] = $row[8];
		$returnvars['comment'] = $row[9];
		$returnvars['join_date'] = $row[10];
		
		$que = sprintf("update person set date='%s' where id='%s'",
				mysql_real_escape_string($date),
				mysql_real_escape_string($returnvars['id']));
		
		$returnvars['date'] = $date;
		mysql_query($que, $connect);
	}
	else{
		$returnvars['is_success'] = "false";
	}
}

echo json_encode($returnvars);

mysql_close($connect);
?>