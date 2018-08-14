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
	<script type="text/javascript" src="functions.js"><!--
	// --></script>
    <title>Registrati</title>
	
  </head>

  
<body>
<p id="par2" style="color:red;"> </p>
<header>
	<img src="logo_poli.png" alt="logo" />
     <h1>PoliConsulting</h1>
</header>

<div class="reg">
<form id="reg" method="post" action="paginaPersonale.php">
  
<label>Non sei ancora registrato? </label> <br><br>
	 <label>Nome:  </label> <br><input type = "text"
    id="name" name = "name" class="textin" class="textin"/> <br> <br>
	
	 <label>Cognome:</label><br> <input type = "text"
    id= "surname" name = "surname" class="textin"/> <br> <br>
	
  <label>Email:  </label><br><input type = "text"
    id="user" name = "username2" class="textin"/><br> <br>
	
  <label>Password (almeno una lettera maiuscola, una minuscola e una cifra):</label> <br><input type = "password"
    id="pass" name = "password2" class="textin"/><br> <br>
	
	  <input class="butt1" type="button" value="Registrati" onClick="verify_fields()">
	  
 </form><br><br><br>
 </div>
 
 <footer> 
<ul class="footer">
  <li><a href="index.php">Home</a></li>
  <li><a href="login.php">Login</a></li>
  <li><a href="registrazione.php">Registrati</a></li>
</ul>
</footer> 
</div>
</body>
</html>