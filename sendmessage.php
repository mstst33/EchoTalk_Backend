<?php
// Send notification message to user
// Connect
$host_name = "";
$user_name = "";
$user_password = "";
$db_name = "";
$connect = mysql_connect($host_name, $user_name, $user_password);
mysql_select_db($db_name, $connect);

//$sql = "SELECT auth_code FROM echo_info WHERE num=1";
//$result = mysql_query($sql, $connect);
//$authCode = mysql_fetch_object($result);

$que = "SELECT reg_id from person WHERE id=''";
$result = mysql_query($que, $connect);
$regID = mysql_fetch_object($result);

// echo $regID->reg_id;
//echo $authCode->auth_code;


$headers = array(
 'Content-Type:application/json',
 'Authorization:key='
);

$arr = array();
$arr['data'] = array();
$arr['data']['msg'] = "Hello, GCM"; 
$arr['registration_ids'] = array();
$arr['registration_ids'][0] = $regID->reg_id;



$ch = curl_init();


curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arr));
$response = curl_exec($ch);
echo $response;
curl_close($ch);
?>