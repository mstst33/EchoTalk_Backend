<?
$temp_reg_id = $_POST['id'];
$temp_id = $_POST['sender_id'];

include "connect_db.php";

$que = sprintf("update person set reg_id='%s' where id='%s'",
				mysql_real_escape_string($temp_reg_id),
				mysql_real_escape_string($temp_id));
				
mysql_query($que, $connect);

echo "Success";
mysql_close($connect);
?>