<?php
$host_name = "";
$user_name = "";
$user_password = "";
$db_name = "";
$connect = mysql_connect($host_name, $user_name, $user_password);
mysql_select_db($db_name, $connect);

//$regID = $_POST['reg_id'];


$returnvars = array();
$returnvars['reg_id'] = "";
$returnvars['succeed'] = "true";

$que = "SELECT picture_data FROM person WHERE id=''";
$result = mysql_query($que, $connect);
$picture = mysql_fetch_object($result);

echo $picture->picture_data;

mysql_close($connect);
?>