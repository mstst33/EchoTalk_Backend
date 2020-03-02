<html>
<head>
<title>Vocagame Server</title>
</head>

<body>

<?php
$host_name = "";
$user_name = "";
$user_password = "";
$db_name = "";
$connect = mysql_connect($host_name, $user_name, $user_password);
mysql_select_db($db_name, $connect);

$usercmd = $_POST['usercmd'];
$username = $_POST['username'];
$userid = $_POST['userid'];
$userpw = $_POST['userpw'];
$userage = $_POST['userage'];
$usergender = $_POST['usergender'];
$userscore = $_POST['userscore'];
$usermoney = $_POST['usermoney'];
$usersuccess = $_POST['usersuccess'];
$userstate = $_POST['userstate'];

$returnvars = array();
$returnvars['blanked'] = "blanked";
$returnvars['usersuccess'] = "true";
$returnvars['userstate'] = "0";
$returnvars['username'] = "name";
$returnvars['userid'] = "id";
$returnvars['userpw'] = "pw";
$returnvars['userage'] = "28";
$returnvars['usergender'] = "1";
$returnvars['userscore'] = "40";
$returnvars['usermoney'] = "10";
$returnvars['usercmd'] = "quitcmd";

switch($usercmd){	
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
	
case "delete":
	msg("delete request\n");
	$que = "DELETE FROM member WHERE memID=$userid";
	mysql_query($que, $connect);
	mysql_free_result($que);
	break;
							
case "modify":
	msg("modify request\n");
	$que = "UPDATE member SET memSCORE=0 WHERE memID=$userid";
	mysql_query($que, $connect);
	mysql_free_result($que);
	$que = "SELECT memSCORE FROM member WHERE memID=$userid";
	$data = mysql_query( $que, $connect );
	break;

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

echo(http_build_query($returnvars));
mysql_close($connect);

function msg($msg)
{
    echo "SERVER >> ".$msg;
}
?>

</body>
</html>