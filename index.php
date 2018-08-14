<?php include('functionsLogged.php');
	setcookie('s239774_check_cookie',1);
	$sumRich=getSumRich();
	$sumAss=getSumAss();
	$row=getPrenotazioni();
	if($row==0){$count=0;}
	else $count=count($row);
		?>

<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
	<link rel="stylesheet" href="mystyle.css">
    <title>HOME</title>
  </head>

<body> 
<header>
	<img src="logo_poli.png" alt="logo" />
     <h1>PoliConsulting</h1>
</header>

<h2><br><br><br>Prenota la tua consulenza di questa settimana!</h2>
<h2>Accedi e seleziona la durata di cui avresti bisogno:</h2>
<h2>ti verrà assegnato un turno tra le 14:00 e le 17:00 di Giovedì</h2>
<h3>Prenotazioni attuali:</h3> 


<?php if($count>0){ ?>
<div class="tab">
<h5>Nome - Cognome - Email - Durata assegnata - Durata richiesta - Inizio intervallo prenotato - Fine intervallo prenotato</h5>
<ul class="tabella">
<?php for($i=0;$i<$count;$i++){ 
  $res=$row[$i];
  echo "<li>".$res[0]."   ".$res[1]."   ".$res[2]."   ".$res[3]."   ".$res[4]."   ".$res[5]."   ".$res[6]."</li><br>";
}
?>
<br>
<li>Totale minuti richiesti - Totale minuti assegnati</li> <br>
<?php echo "<li>".$sumRich." ".$sumAss."</li>"; ?>
</ul>
 </div>
 
 <?php }else{ 
echo "<h4>Nessuna prenotazione ancora effettuata</h4>";}
?>
<footer> 
<ul class="footer">
  <li><a href="index.php">Home</a></li>
  <li><a href="login.php">Login</a></li>
  <li><a href="registrazione.php">Registrati</a></li>
</ul>
</footer> 

</body>
</html>
