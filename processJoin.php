<html>
<head>
<title>Process Join</title>
<body>
<?php
$id=$_POST['id'];
$pw=$_POST['pw'];
$name=$_POST['name'];
$age=$_POST['age'];
$gender=$_POST['gender'];

$host_name = "";
$user_name = "";
$user_password = "";
$db_name = "";
$connect = mysql_connect($host_name, $user_name, $user_password);
mysql_select_db($db_name, $connect);

$sql = "insert into member values('$id','$pw','$name','$age','$gender','0', '0')";
mysql_query($sql, $connect);
mysql_close($connect);

echo "register completed";
?>
</body>
</html>