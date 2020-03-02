<?php
include "connect_db.php";

$user_id = $_POST['user_id'];
$user_name = $_POST['user_name'];
$user_age = $_POST['user_age'];
$user_gender = $_POST['user_gender'];
$user_comment = $_POST['user_comment'];
$writing_num = $_POST['writing_num'];

$base = $_REQUEST['image'];
$HOME = $_SERVER['DOCUMENT_ROOT'];

if(!empty($base)){
	// base64 encoded utf-8 string
	$binary = base64_decode($base);
	
	// binary, utf-8 bytes
	// header('Content-Type: bitmap; charset=utf-8');
	
	$photo_name = "$HOME/echo/image/photo_$writing_num.png";
	$file = fopen($photo_name, 'wb');
	fwrite($file, $binary);
	fclose($file);
	$image = 'photo_'.$writing_num.'.png';
	$que = sprintf("update person set name='%s', age='%s', 
				gender='%s', picture_data='%s', comment='%s' where id='%s'",
				mysql_real_escape_string($user_name),
				mysql_real_escape_string($user_age),
				mysql_real_escape_string($user_gender),
				mysql_real_escape_string($image),
				mysql_real_escape_string($user_comment),
				mysql_real_escape_string($user_id));
}
else{
	$image = "0";
	$que = sprintf("update person set name='%s', age='%s', 
				gender='%s', comment='%s' where id='%s'",
				mysql_real_escape_string($user_name),
				mysql_real_escape_string($user_age),
				mysql_real_escape_string($user_gender),
				mysql_real_escape_string($user_comment),
				mysql_real_escape_string($user_id));
}

$result = mysql_query($que, $connect);

$returnvars = array();
$returnvars['is_success'] = "true";
if(!$result){
	$returnvars['is_success'] = "false";
}

echo json_encode($returnvars);
mysql_close($connect);

?>