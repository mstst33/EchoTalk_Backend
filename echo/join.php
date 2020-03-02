<?php
include "connect_db.php";

$userid = $_POST['id'];
$userpw = $_POST['passwd'];
$usermail = $_POST['mail_address'];
$userdeviceid = $_POST['device_id'];
$date = $_POST['date'];

$que = sprintf("SELECT id FROM person WHERE id='%s'",
				mysql_real_escape_string($userid));
$re = mysql_query($que, $connect);
$num = mysql_num_rows($re);
$returnvars = array();

// 같은 아이디가 있으면 즉 데이타 베이스에서 데이타를 찾으면 false를 반환.. 이상하다
if($num < 1){
	$que = "INSERT INTO person VALUES(
		'$userid', '$userpw',
			'', 0, 0, '00000000',
		'0', '$usermail', '', '', '1',
		'$userdeviceid', '0', 0, 0, '0', '0', '$date', '$date')";
	mysql_query($que, $connect);

	$que = "update echo_info set num_people=num_people+1 where num=1";
	mysql_query($que, $connect);

	$returnvars['is_success'] = "true";
	$returnvars['id'] = $userid;
	$returnvars['email'] = $usermail;
	$returnvars['date'] = $date;
	$returnvars['join_date'] = $date;
}
else{
	$returnvars['is_success'] = "false";
}

echo json_encode($returnvars);

mysql_close($connect);
?>