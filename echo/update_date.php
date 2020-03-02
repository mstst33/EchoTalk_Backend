<?php
include "connect_db.php";

$user_id = $_POST['user_id'];
$date = $_POST['date'];

$que = sprintf("update person set date='%s' where id='%s'",
				mysql_real_escape_string($date),
				mysql_real_escape_string($user_id));

$result = mysql_query($que, $connect);

$returnvars = array();

if(!$result){
	$returnvars['is_success'] = "false";
}
else{
	$returnvars['is_success'] = "true";
}

echo json_encode($returnvars);

mysql_close($connect);
?>