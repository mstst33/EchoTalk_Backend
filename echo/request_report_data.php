<?php
include "connect_db.php";

$date = $_POST['date'];
$user_id = $_POST['user_id'];
$writer_id = $_POST['writer_id '];
$theme = $_POST['theme'];
$writing_num = $_POST['writing_num'];
$report_text = $_POST['report_text'];
/*
$date = '2013.11.29 15:32:46';
$user_id = 'mstst';
$writer_id = 'shkoma';
$theme = '0';
$writing_num = '1385706766556';
$report_text = 'There is not any text';
*/
$que = "INSERT INTO echo_report VALUES(
		'', '$date', '$user_id', '$writer_id',
		'$theme', '$writing_num', '$report_text')";
		
$re = mysql_query($que, $connect);
$returnvars = array();

if(!$re)
	$returnvars['is_success'] = "false";
else
	$returnvars['is_success'] = "true";


echo json_encode($returnvars);

mysql_close($connect);
?>