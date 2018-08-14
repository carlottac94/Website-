<?php include('functionsLogged.php');
	setcookie('s239774_check_cookie',1);
	
	if(isset($_REQUEST['msg'])){
			$msg= htmlentities($_REQUEST['msg']);
			echo ("<p style=\"color:red; \">".$msg."</p>");
		}?>

 
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
	<link rel="stylesheet" href="mystyle.css">
	<script type="text/javascript" src="functions.js"> <!--
	// --></script>
    <title>LOGIN</title>
  </head>


<body>

<p id="par" style="color:red;"> </p>
  <header>
	<img src="logo_poli.png" alt="logo" />
     <h1>PoliConsulting</h1>
</header>
<div class="login">
<form id="log" method="post" action="paginaPersonale.php" >

<label>Accedi: </label> <br><br>
  <label>Email:</label> <br><input type = "text"
    id= "user" name = "username" class="textin"/><br><br><br>
	
  <label>Password:</label> <br><input type = "password"
    id="pass" name = "password" class="textin"/> <br> <br>
	
	  <input type="button" class="butt" value="Login" onClick="check_fields()">
	  
 </form> <br><br>
 </div>
 <footer> 
<ul class="footer">
  <li><a href="index.php">Home</a></li>
  <li><a href="login.php">Login</a></li>
  <li><a href="registrazione.php">Registrati</a></li>
</ul>
</footer> 

</body>
</html>