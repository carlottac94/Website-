<?php  include('functionsLogged.php');	
 check_https();
 $flag=-1;
  if(isset( $_POST['username']) && isset( $_POST['password'])){
$username= htmlentities($_POST['username']);
$password= htmlentities($_POST['password']);

  if(authentication($username,$password)==FALSE){
	  RedirectToLogin("Attenzione: email o password errate");	
	  }

  manage_session();
  $_SESSION['s239774_myuser']=$username;
  $name=getName($username);
  $surname=getSurname($username);
  $durata=getDurata($username);
  }
  else{
	  
	  if(isset( $_POST['name']) && isset( $_POST['surname']) && isset( $_POST['username2']) && isset( $_POST['password2'])){
$name= htmlentities($_POST['name']);
$surname= htmlentities($_POST['surname']);
$password= htmlentities($_POST['password2']);
$durata=0;
if (!((preg_match(".[a-z]+.", $password)) && (preg_match(".[0-9]+.", $password)) && (preg_match(".[A-Z]+.", $password)))) {
   RedirectToReg("Attenzione: la password deve contenere almeno una lettera maiuscola, una minuscola e un numero");	
}
$username= htmlentities($_POST['username2']);
if (!(preg_match(".@[a-zA-z]+\..", $username))) {
   RedirectToReg("Attenzione: l' email inserita non è valida");	
}
verify_newUser($username);

InsertUtente($name, $surname, $password, $username);
manage_session();
  $_SESSION['s239774_myuser']=$username;
  $name=getName($username);
  $surname=getSurname($username);
	  }
  else{
	  manage_session();
	  
	  if(isset($_SESSION['s239774_myuser'])){
		   if(isset($_REQUEST['Logout'])){
					logout();
				}
		   $username=$_SESSION['s239774_myuser'];
		
		   if (isset($_REQUEST['durata'])){
			   if(getDurata($username)==0){
			$durata=sanitizeString($_REQUEST['durata']);
			
			if($durata>180){
				echo('<script type="text/javascript"> <!--
            alert("La durata richiesta deve essere minore di 180 minuti");
            // --></script>
			<noscript> Sorry: Your browser does not support Javascript or it is
			disabled</noscript>'); 
			}
			
			else{
				
				$ret=InsertRichiesta($durata,$username);
				if($ret==false){
					$flag=1;
				}
				else $flag=0;
			}
			   }
			else{
			  echo('<script type="text/javascript"> <!--
            alert("Una richiesta è stata già effettuata. Cancellare la vecchia per farne una nuova");
            // --></script>
			<noscript> Sorry: Your browser does not support Javascript or it is
			disabled</noscript>'); 
			}
			
			}
	 
			else{
				if(isset($_REQUEST['Reset'])){
				$d=getDurata($username);
			if($d==0){
				echo('<script type="text/javascript"> <!--
            alert("Nessuna richiesta da cancellare!");
            // --></script>
			<noscript> Sorry: Your browser does not support Javascript or it is
			disabled</noscript>'); 
			}
					deleteRichiesta($username);
					$flag=2;
				}
			}
	
			
	   
		  
	  $name=getName($username);
      $surname=getSurname($username);
	  $durata=getDurata($username);
	  }
	  else{
	  RedirectToLogin("Loggarsi per accedere all' area personale");
	  }
  }
  }
  
  check_cookies();
   ?>

<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
	<link rel="stylesheet" href="mystyle.css">
	<script type="text/javascript" src="functions.js"> <!--
	// --></script>
    <title>Area Riservata</title>
  </head>

<body>
<p id="par3" style="color:red;"> </p>
 <header>
	<img src="logo_poli.png" alt="logo" />
     <h1>PoliConsulting</h1> 
</header> 
<h1>Benvenuto/a <?php echo("$name $surname"); ?></h1>
<div class="areaRis">
<form id="num" method="post" action="paginaPersonale.php">
 <input type = "text" class="textin" id="durata" name = "durata" value= <?php echo($durata);
?>> <br>

 <input type="button" class="butt1" value="Ok" onClick="check_inputs()">
</form> <br> <br>

<form method="post" action="paginaPersonale.php">
<input type="submit" class="butt1" value="Logout" name="Logout">
</form>

<form method="post" action="paginaPersonale.php">
<input type="submit" class="butt1" value="Reset" name="Reset" >
</form>

<?php 
		if($flag==0){
				echo("<p class='pos'>Prenotazione effettuata con successo! Vedi la tabella delle prenotazioni nella home</p>"); 
			}
			else if($flag==1){
				echo("<p class='neg'>Non è possibile effettuare nuove prenotazioni, durata massima raggiunta. Attendere cancellazioni e riprovare</p>"); 
			}
			else if($flag==2){
				echo("<p class='pos'>Cancellazione effettuata con successo!</p>"); 
			}
?>
</div>



</body>
</html>