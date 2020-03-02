<?php
include "connect_db.php";

$id = $_POST['string_id'];
$pw = $_POST['passwd'];
$device_id = $_POST['device_id'];
$date = $_POST['date'];

$que = sprintf("SELECT id, pw, name, gender, age, interested_theme, picture_data, email, comment, join_date FROM person WHERE id='%s'",
				mysql_real_escape_string($id));
				
$re = mysql_query($que, $connect);

$returnvars = array();

if(!$re){
	$returnvars['is_success'] = "false";
}
else{
	$row = mysql_fetch_row($re);

	$returnvars['id'] = $row[0];
	$returnvars['pw'] = $row[1];
	$returnvars['name'] = $row[2];
	$returnvars['gender'] = $row[3];
	$returnvars['age'] = $row[4];
	$returnvars['interested_theme'] = $row[5];
	$returnvars['picture_data'] = $row[6];
	$returnvars['email'] = $row[7];
	$returnvars['comment'] = $row[8];
	$returnvars['join_date'] = $row[9];
	
	if(!empty($row[0]) && $pw == $row[1]){
		$returnvars['is_success'] = "true";
	}
	else{
		$returnvars['is_success'] = "false";
	}
	
	$que = sprintf("update person set deviceID='%s', date='%s' where id='%s'",
				mysql_real_escape_string($device_id),
				mysql_real_escape_string($date),
				mysql_real_escape_string($id));
				
	mysql_query($que, $connect);
	
	$returnvars['date'] = $date; 
}

echo json_encode($returnvars);

mysql_close($connect);
?>