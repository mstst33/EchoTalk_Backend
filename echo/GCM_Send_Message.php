<?
$headers = array(
 'Content-Type:application/json',
 'Authorization:key='
);

$temp_sender_id = $_POST['sender_id'];
$temp_id = $_POST['id'];
$temp_msg = $_POST['msg'];
$temp_writing_num = $_POST['writing_num'];
$temp_selectedInfo = $_POST['selectedInfo'];

include "connect_db.php";

$que = sprintf("select reg_id from person where id='%s'",
				mysql_real_escape_string($temp_id));

$result = mysql_query($que, $connect);

if(!$result){
}
else{
	$reg_id = mysql_result($result, 0, "reg_id");
	
	$arr = array();
	$arr['data'] = array();
	$arr['data']['msg'] = "$temp_msg";
	$arr['data']['id'] = "$temp_sender_id";
	$arr['data']['selectedInfo'] = "$temp_selectedInfo";
	$arr['data']['writing_num'] = "$temp_writing_num";
	$arr['registration_ids'] = array();
	$arr['registration_ids'][0] = "$reg_id";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
	$response = curl_exec($ch);
	echo $response;

	curl_close($ch);
}

mysql_close($connect);
?>