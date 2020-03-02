<?php
$host_name = "";
$user_name = "";
$user_password = "";
$db_name = "";
$connect = mysql_connect($host_name, $user_name, $user_password);
mysql_select_db($db_name, $connect);

$regID = $_POST['regid'];

$que = "UPDATE person SET reg_id='$regID' WHERE id=''";
mysql_query($que, $connect);

// $que = "select reg_id from person WHERE id=''";
// $data = mysql_query($que, $connect);
//$authCode = mysql_fetch_object($data);

//print($authCode->reg_id);

$returnvars = array();
$returnvars['regid'] = $regID;
$returnvars['succeed'] = true;

//mysql_free_result($que);
/*
switch($usercmd){
// 회원가입
case "join":
	msg("join request\n");
	$que = "INSERT INTO member VALUES(
	'$userid', '$userpw',
	'$username', '$userage',
	'$usergender','$userscore',
	'$usermoney')";
	mysql_query($que, $connect);
	mysql_free_result($que);
	break;
	
// 회원탈퇴
case "delete":
	msg("delete request\n");
	$que = "DELETE FROM member WHERE memID=$userid";
	mysql_query($que, $connect);
	mysql_free_result($que);
	break;
							
// 회원수정
case "modify":
	msg("modify request\n");
	$que = "UPDATE member SET memSCORE=0 WHERE memID=$userid";
	mysql_query($que, $connect);
	mysql_free_result($que);
	$que = "SELECT memSCORE FROM member WHERE memID=$userid";
	$data = mysql_query( $que, $connect );
	break;

// 회원정보
case "get":
	msg("get request\n");
	$que = "SELECT memSCORE FROM member WHERE memID=$userid";
	$data = mysql_query($que, $connect);
	mysql_free_result($que);
	break;
						
default:
    msg("client invalid command\n");
    break;
}
//sort($returnvars, SORT_STRING);
*/
print(json_encode($returnvars));
mysql_close($connect);

function msg($msg)
{
    echo "SERVER >> ".$msg;
}
?>