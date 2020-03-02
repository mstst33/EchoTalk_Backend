<?php
include "connect_db.php";

$selectedinfo = $_POST['selectedInfo'];
$userid = $_POST['userID'];
$writing_num = $_POST['writing_num'];
$writing_date = $_POST['writing_date'];
$location = $_POST['location'];
$base = $_REQUEST['image'];

$returnvars = array();
if($location == "" || $location == "-1.0 -1.0"){
	$returnvars['is_success'] = false;
}
else{
	$returnvars['is_success'] = true;

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
}
else
	$image = "0";

switch($selectedinfo){
	case 0:
		$daily_writing_content = $_POST['daily_writing_content'];
		$que = "INSERT INTO normal_table VALUES(
				'$daily_writing_content', '$writing_date',
				'$image','$location', '$writing_num', '$userid', 0, '')";
		break;
	case 1:
		$travel_subject = $_POST['travel_subject'];
		$returnvars['msg'] = $travel_subject;
		$travel_date = $_POST['travel_date'];
		$travel_period = $_POST['travel_period'];
		$travel_number_addmitted = $_POST['travel_number_addmitted'];
		$travel_place = $_POST['travel_place'];
		$travel_writing_content = $_POST['travel_writing_content'];
		$que = "INSERT INTO travel_table VALUES(
				'$travel_subject', '$travel_writing_content',
				'$writing_date', '$image',
				'$travel_number_addmitted', '$travel_date',
				'$travel_period', '$travel_place',
				'$location','$writing_num', '$userid', 0, 0, '', '')";
		break;
	case 2:
		$exercise_subject = $_POST['exercise_subject'];
		$returnvars['msg'] = $exercise_subject;
		$exercise_start_date = $_POST['exercise_start_date'];
		$exercise_duration_per_day = $_POST['exercise_duration_per_day'];
		$exercise_number_addmitted = $_POST['exercise_number_addmitted'];
		$exercise_place = $_POST['exercise_place'];
		$exercise_writing_content = $_POST['exercise_writing_content'];
		$que = "INSERT INTO exercise_table VALUES(
				'$exercise_subject', '$exercise_writing_content',
				'$writing_date', '$image',
				'$exercise_number_addmitted', '$exercise_start_date',
				'$exercise_duration_per_day', '$exercise_place',
				'$location','$writing_num', '$userid', 0, 0, '', '')";
		break;
	case 3:
		$hobby_subject = $_POST['hobby_subject'];
		$returnvars['msg'] = $hobby_subject;
		$hobby_start_date = $_POST['hobby_start_date'];
		$hobby_duration_per_day = $_POST['hobby_duration_per_day'];
		$hobby_number_addmitted = $_POST['hobby_number_addmitted'];
		$hobby_place = $_POST['hobby_place'];
		$hobby_writing_content = $_POST['hobby_writing_content'];
		$que = "INSERT INTO hobby_table VALUES(
				'$hobby_subject', '$hobby_writing_content',
				'$writing_date', '$image',
				'$hobby_number_addmitted', '$hobby_start_date',
				'$hobby_duration_per_day', '$hobby_place',
				'$location','$writing_num', '$userid', 0, 0, '', '')";
		break;
	case 4:
		$study_subject = $_POST['study_subject'];
		$returnvars['msg'] = $study_subject;
		$study_start_date = $_POST['study_start_date'];
		$study_duration_per_day = $_POST['study_duration_per_day'];
		$study_day_of_week = $_POST['study_day_of_week'];
		$study_number_addmitted = $_POST['study_number_addmitted'];
		$study_place = $_POST['study_place'];
		$study_writing_content = $_POST['study_writing_content'];
		$que = "INSERT INTO study_table VALUES(
				'$study_subject', '$study_writing_content',
				'$writing_date', '$image',
				'$study_number_addmitted', '$study_start_date',
				'$study_duration_per_day', '$study_place',
				'$study_day_of_week','$location',
				'$writing_num', '$userid', 0, 0, '', '')";
		break;
	case 5:
		$question_subject = $_POST['question_subject'];
		$returnvars['msg'] = $question_subject;
		$question_is_completed = $_POST['question_is_completed'];
		$question_writing_content = $_POST['question_writing_content'];
		$que = "INSERT INTO question_table VALUES(
				'$question_subject', '$question_writing_content',
				'$writing_date', '$image',
				'$question_is_completed', '$location',
				'$writing_num', '$userid', 0, '')";
		break;
	case 6:
		$job_subject = $_POST['job_subject'];
		$returnvars['msg'] = $job_subject;
		$job_start_date = $_POST['job_start_date'];
		$job_duration_per_day = $_POST['job_duration_per_day'];
		$job_day_of_week = $_POST['job_day_of_week'];
		$job_number_addmitted = $_POST['job_number_addmitted'];
		$job_pay = $_POST['job_pay'];
		$job_place = $_POST['job_place'];
		$job_writing_content = $_POST['job_writing_content'];
		$que = "INSERT INTO work_table VALUES(
				'$job_subject', '$job_writing_content',
				'$writing_date', '$image',
				'$job_number_addmitted', '$job_day_of_week',
				'$job_start_date', '$job_duration_per_day',
				'$job_place', '$job_pay', '$location',
				'$writing_num', '$userid', 0, 0, '', '')";
		break;
	case 7:
		$used_subject = $_POST['used_subject'];
		$returnvars['msg'] = $used_subject;
		$used_start_date = $_POST['used_start_date'];
		$used_product_classification = $_POST['used_product_classification'];
		$used_buy_or_sell = $_POST['used_buy_or_sell'];
		$used_is_completed = $_POST['used_is_completed'];
		$used_asking_price = $_POST['used_asking_price'];
		$used_mode_of_dealing = $_POST['used_mode_of_dealing'];
		$used_writing_content = $_POST['used_writing_content'];
		$que = "INSERT INTO sellby_table VALUES(
				'$used_subject', '$used_writing_content',
				'$writing_date', '$image',
				'$used_product_classification', '$used_buy_or_sell',
				'$used_is_completed', '$used_asking_price',
				'$used_mode_of_dealing', '$location',
				'$writing_num', '$userid', 0, 0, '', '')";
		break;
}
	
mysql_query($que, $connect);

// $daily_writing = iconv('CP949', 'UTF-8', $_POST['daily_writing_content']);
$que = sprintf("SELECT echo_room FROM person WHERE id='%s'",
				mysql_real_escape_string($userid));
$re = mysql_query($que, $connect);
$result = mysql_fetch_row($re);

if($result[0] == '0')
	$str = $selectedinfo.'/'.$writing_num.'/'.$writing_date.'/'.'0'.'/'.'0'.'/'.'0'; // theme/writingnum/date/join/echo/ShoutorJorEor (0or1or2)
else
	$str = $result[0].';'.$selectedinfo.'/'.$writing_num.'/'.$writing_date.'/'.'0'.'/'.'0'.'/'.'0';
	
$que = sprintf("update person set location='%s', e_num=e_num+1, echo_room='%s' where id='%s'",
				mysql_real_escape_string($location),
				mysql_real_escape_string($str),
				mysql_real_escape_string($userid));

$result = mysql_query($que, $connect);

if(!$result){
	$returnvars['is_success'] = "false";
}

$returnvars['writing_num'] = $writing_num;
$returnvars['selectedInfo'] = $selectedinfo;
}

echo json_encode($returnvars);
mysql_close($connect);
?>