<?php
include "connect_db.php";

$user_id = $_POST['user_id'];

$que = sprintf("SELECT * FROM person where id='%s'",
				mysql_real_escape_string($user_id));	
											
$re = mysql_query($que, $connect);

$returnvars = array();
if(!$re){
	$returnvars['is_success'] = "false";
}
else{
	$row = mysql_fetch_row($re);
	$count = mysql_num_fields($re);
	
	$returnvars['is_success'] = "true";
	$returnvars['result'] = array();
	
	for($i = 0; $i < $count; ++$i){
		$returnvars['result'][$i] = $row[$i];
	}
}

echo json_encode($returnvars);

mysql_close($connect);
?>