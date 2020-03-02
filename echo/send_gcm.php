<?php
include "connect_db.php";
include "distance_setting.php";

$selectedinfo = $_POST['selectedInfo'];
$head = $_POST['head'];
$userid = $_POST['userID'];
$msg = $_POST['msg'];
$writing_num = $_POST['writing_num'];
$location = $_POST['location'];
$setting_distance = $_POST['setting_distance'];
$setting_range = $_POST['setting_range'];

	$headers = array('Content-Type:application/json',
 					'Authorization:key=');
	
	$arr   = array();
	$arr['data'] = array();
	$arr['data']['id'] = "$userid";
	$arr['data']['msg'] = "$head"." "."$msg";
	$arr['data']['selectedInfo'] = "$selectedinfo";
	$arr['data']['writing_num'] = "$writing_num";
	$arr['registration_ids'] = array();
	
	$whole_num_people = 0;
	$num_people = 0;
	
	// 자신의 위치를 기준으로 설정한 거리에 있는 사람들에게 메시지가 간다
	if($setting_range == 1){
		$que = sprintf("SELECT interested_theme, reg_id, location, isLogin FROM person where id!='%s'",
						mysql_real_escape_string($userid));
		$re = mysql_query($que, $connect);
		
		switch($setting_distance){
			case 1:
				while($row = mysql_fetch_assoc($re)){
					if($row['isLogin'] == 1){
						$resultDistance = getKMBetweenDistances($location, $row['location']);
					
						if($resultDistance < $near){
							$theme = $row['interested_theme'];
							if($theme{$selectedinfo} == 1){
								++$whole_num_people;
								$arr['registration_ids'][$num_people++] = $row['reg_id'];
								
								if($num_people >= 1000){
									$num_people = 0;
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
									
									$arr['registration_ids'] = array();
								}
							}
						}
					}
				}
				break;
			case 2:
				while($row = mysql_fetch_assoc($re)){
					if($row['isLogin'] == 1){
						$resultDistance = getKMBetweenDistances($location, $row['location']);
					
						if($resultDistance < $far){
							$theme = $row['interested_theme'];
							if($theme{$selectedinfo} == 1){
								++$whole_num_people;
								$arr['registration_ids'][$num_people++] = $row['reg_id'];
								
								if($num_people >= 1000){
									$num_people = 0;
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
									
									$arr['registration_ids'] = array();
								}
							}
						}
					}
				}
				break;
			case 3:
				while($row = mysql_fetch_assoc($re)){
					if($row['isLogin'] == 1){
						$resultDistance = getKMBetweenDistances($location, $row['location']);
					
						if($resultDistance < $very_far){
							$theme = $row['interested_theme'];
							if($theme{$selectedinfo} == 1){
								++$whole_num_people;
								$arr['registration_ids'][$num_people++] = $row['reg_id'];
								
								if($num_people >= 1000){
									$num_people = 0;
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
									
									$arr['registration_ids'] = array();
								}
							}
						}
					}
				}
				break;
		}
		
		if($num_people > 0){
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
	}
	else if($setting_range == 2){
		$que = sprintf("SELECT interested_theme, reg_id, isLogin FROM person where id!='%s'",
						mysql_real_escape_string($userid));
		$re = mysql_query($que, $connect);
		
		while($row = mysql_fetch_assoc($re)){
			if($row['isLogin'] == 1){
				$theme = $row['interested_theme'];
				if($theme{$selectedinfo} == 1){
					++$whole_num_people;
					$arr['registration_ids'][$num_people++] = $row['reg_id'];
								
					if($num_people >= 1000){
						$num_people = 0;
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
						
						$arr['registration_ids'] = array();
					}
				}
			}
		}
		if($num_people > 0){
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
	}
	
	mysql_close($connect);
?>