<html>
<head>
<title>Sign up page</title>
<body>
<script>
function chk_frm(){
    if(!document.join.id.value){
    	window.alert('Please Input ID');
    	document.join.id.focus();
    	return false;
    }
   
    if(!document.join.pw.value){
    	window.alert('Please Input Password');
    	document.join.pw.focus();
    	return false;
    }
	
	if(!document.join.pw2.value){
    	window.alert('Please Input Password2');
    	document.join.pw2.focus();
    	return false;
    }
	
	if(document.join.pw.value != document.join.pw2.value){
		window.alert('Password you input is not corrected with another one!');
    	document.join.pw.focus();
		return false;
	}
	
    if(!document.join.name.value){
    	window.alert('Please input your name');
    	document.join.name.focus();
    	return false;
    }
	
	if(!document.join.age.value){
    	window.alert('Please input your age');
    	document.join.age.focus();
    	return false;
	}
	
	return true;  
}
</script>

<form name=join method=post action="processJoin.php" OnSubmit="return chk_frm()">
<h2>Input your information</h2>
<table border=1>
<tr>
<td colspan=1 bgcolor=#D4F4FA align=center>ID</td>
<td><input type="text" size=30 name='id'></td>
</tr>
<tr>
<td colspan=1 bgcolor=#D4F4FA align=center>Password</td>
<td><input type="password" size=30 name='pw'></td>
</tr>
<tr>
<td colspan=1 bgcolor=#D4F4FA align=center>Confirm Password</td>
<td><input type="password" size=30 name='pw2'></td>
</tr>
<tr>
<td colspan=1 bgcolor=#D4F4FA align=center>Name</td>
<td><input type="text" size=12 maxlength=10 name='name'></td>
</tr>
<tr>
<td colspan=1 bgcolor=#D4F4FA align=center>Age</td>
<td><input type="text" size=6 maxlength=2 name='age'></td>
</tr>
<tr>
<td colspan=1 bgcolor=#D4F4FA align=center>Gender</td>
<td>
<input type="radio" value=1 name='gender' checked> Male
<input type="radio" value=2 name='gender'> Female
</td>
</tr>
</table>
<input type=submit value="Join"><input type=reset value="Rewrite"><input type="button" value="Exit" OnClick="window.close()">
</form>
</body>
</html>