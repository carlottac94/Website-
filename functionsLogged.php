<?php

function manage_session(){
session_start(); 
$t=time();
$diff=0;

if (isset($_SESSION['s239774_time'])){
    $t0=$_SESSION['s239774_time'];
    $diff=($t-$t0);  // inactivity period
}
if ($diff > 120) { // inactivity period too long 
   logout();
   RedirectToHome("Sessione scaduta: fai il login");
   exit; // IMPORTANT to avoid further output from the script
  
} else {
    $_SESSION['s239774_time']=time(); /* update time */
    //echo '<html><body>Updated last access time: '.$_SESSION['time'].'</body></html>';
}
}

function dbConnect() {
   // $conn = mysqli_connect("localhost","s239774","phapross");
   $conn = mysqli_connect("localhost","root","");
    if(mysqli_connect_error())
        die("Error when connecting to the db: "
            .mysqli_connect_errno()."-".mysqli_connect_error());
   // if(!@mysqli_select_db($conn,"s239774"))
	   if(!@mysqli_select_db($conn,"utenti"))
        die("Error when selecting the db: ".mysqli_error($conn));
    return $conn;
}

function sanitizeString($var) {
	$conn=dbConnect();
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripcslashes($var);
	return mysqli_real_escape_string($conn,$var);
}

function authentication($user, $password) {
    $conn = dbConnect();
    $user = sanitizeString($user);
    $password = sanitizeString($password);
    	$sql = "SELECT `Password` FROM `Utenti_Consul` WHERE `Email` = '". $user . "'";
    $resp = mysqli_query($conn,$sql);
    if(!$resp)
		die("Error in query: ".$sql."<br>".mysqli_error($conn));
    if (mysqli_num_rows($resp) == 0)
    	return FALSE;
   $row = mysqli_fetch_array($resp, MYSQLI_NUM);
    $res = (md5($password) == $row[0]);
    mysqli_close($conn); 
    return ($res);
	

}

function verify_newUser($user){
	 $conn = dbConnect();
   $user = sanitizeString($user);
	$sql = "SELECT `Email` FROM `Utenti_Consul` WHERE `Email` = '". $user . "'";
    $resp = mysqli_query($conn,$sql);
    if(!$resp)
		die("Error in query: ".$sql."<br>".mysqli_error($conn));
	 if (mysqli_num_rows($resp) != 0)
    	RedirectToReg("Attenzione, lo user inserito per la registrazione è già esistente");
	mysqli_close($conn);
}


function RedirectToHome($msg="") {
header ('HTTP/1.1 307 temporary redirect');
header	("Location: index.php?msg=".urlencode($msg));
exit;
}

function RedirectToLogin($msg="") {
header ('HTTP/1.1 307 temporary redirect');
header	("Location: login.php?msg=".urlencode($msg));
exit;
}

function RedirectToReg($msg="") {
header ('HTTP/1.1 307 temporary redirect');
header	("Location: registrazione.php?msg=".urlencode($msg));
exit;
}

function InsertUtente($name, $surname, $password, $username){
$conn=dbConnect();
$passwod=sanitizeString($password);
$sql="INSERT INTO `Utenti_Consul` (`Email`, `Password`,`Nome`, `Cognome`,`Durata_richiesta`,`Durata_assegnata`,`Inizio_assegnato`, `Fine_assegnata`) VALUES
('".$username."', md5('".$password."'),'".$name."','".$surname."',0,0,'00:00:00','00:00:00')";
 $resp = mysqli_query($conn,$sql);
    if(!$resp)
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
	    mysqli_close($conn); 
}

function getName($user) {
  $conn = dbConnect();
   $user = sanitizeString($user);
	$sql = "SELECT `Nome` FROM `Utenti_Consul` WHERE `Email` = '". $user . "'";
    $resp = mysqli_query($conn,$sql);
    if(!$resp)
		die("Error in query: ".$sql."<br>".mysqli_error($conn));
 if (mysqli_num_rows($resp) == 0)
    	die("Error in query: ".$sql."<br>".mysqli_error($conn));
    $row = mysqli_fetch_array($resp, MYSQLI_NUM);
    $res = $row[0];
    mysqli_close($conn); 	
	return $res;
}

function getSurname($user) {
  $conn = dbConnect();
   $user = sanitizeString($user);
	$sql = "SELECT `Cognome` FROM `Utenti_Consul` WHERE `Email` = '". $user . "'";
    $resp = mysqli_query($conn,$sql);
    if(!$resp)
		die("Error in query: ".$sql."<br>".mysqli_error($conn));
 if (mysqli_num_rows($resp) == 0)
    	die("Error in query: ".$sql."<br>".mysqli_error($conn));
    $row = mysqli_fetch_array($resp, MYSQLI_NUM);
    $res = $row[0];
    mysqli_close($conn); 	
	return $res;
}

function getDurata($user) {
  $conn = dbConnect();
   $user = sanitizeString($user);
	$sql = "SELECT `Durata_assegnata` FROM `Utenti_Consul` WHERE `Email` = '". $user . "' FOR UPDATE";
    $resp = mysqli_query($conn,$sql);
    if(!$resp)
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
 if (mysqli_num_rows($resp) == 0)
    	echo("Error in query: ".$sql."<br>".mysqli_error($conn));
    $row = mysqli_fetch_array($resp, MYSQLI_NUM);
    $res = $row[0];
    mysqli_close($conn); 	
	return $res;
}

function getSumRich() {
  $conn = dbConnect();

	$sql = "SELECT SUM(`Durata_richiesta`) FROM `Utenti_Consul` FOR UPDATE";
    $resp = mysqli_query($conn,$sql);
    if(!$resp)
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
 if (mysqli_num_rows($resp) == 0)
    	echo("Error in query: ".$sql."<br>".mysqli_error($conn));
    $row = mysqli_fetch_array($resp, MYSQLI_NUM);
    $res = $row[0];
    mysqli_close($conn); 	
	return $res;
}

function getSumAss() {
  $conn = dbConnect();

	$sql = "SELECT SUM(`Durata_assegnata`) FROM `Utenti_Consul` FOR UPDATE";
    $resp = mysqli_query($conn,$sql);
    if(!$resp)
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
 if (mysqli_num_rows($resp) == 0)
    	echo("Error in query: ".$sql."<br>".mysqli_error($conn));
    $row = mysqli_fetch_array($resp, MYSQLI_NUM);
    $res = $row[0];
    mysqli_close($conn); 	
	return $res;
}

function getPrenotazioni() {
  $conn = dbConnect();

	$sql = "SELECT `Nome`,`Cognome`,`Email`,`Durata_assegnata`,`Durata_richiesta`,`Inizio_assegnato`,`Fine_assegnata` FROM `Utenti_Consul` WHERE `Durata_assegnata`<>'0' ORDER BY `Inizio_assegnato` FOR UPDATE";
    $resp = mysqli_query($conn,$sql);
    if(!$resp)
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
 if (mysqli_num_rows($resp) == 0)
    	return 0;
	for($i=0;$i<mysqli_num_rows($resp);$i++)
    $row[$i] = mysqli_fetch_array($resp, MYSQLI_NUM);
    mysqli_close($conn); 	
	return $row;
}


function InsertRichiesta($value,$username){
	$conn=dbConnect();
	$username=sanitizeString($username);
    
	 mysqli_autocommit($conn,false);
	 $sql1 = "SELECT MAX(`Fine_assegnata`) FROM `Utenti_Consul` FOR UPDATE";
	 $resp1 = mysqli_query($conn,$sql1);
	 
	  if(!$resp1){
		mysqli_rollback($conn);
		echo "Rollback: select max fallita";
	}  
	if (mysqli_num_rows($resp1)== 0){
    	mysqli_rollback($conn);
		echo "Rollback: nessuna risposta ricevuta per max";
	}
	$row1 = mysqli_fetch_array($resp1, MYSQLI_NUM);
    $res1 = $row1[0];

	if($res1=='00:00:00'){
		if($value<59){
			$fine="'14:".$value.":00'";
		}
		else{
			$ore=(int)$value/60;
				$ore=14+$ore;
				$minuti=(int)$value%60;
				$fine="'".$ore.":".$minuti.":00'";
			
		}
		$sql="UPDATE `Utenti_Consul` set `Durata_richiesta`='".$value."',`Durata_assegnata`='".$value."', `Inizio_assegnato`='14:00:00',`Fine_assegnata`=".$fine." WHERE `Email`='".$username."'";
		 $resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
	}  

	}
	
	else
	{
	 $sql2 = "SELECT SUM(`Durata_assegnata`),COUNT(`Durata_assegnata`) FROM `Utenti_Consul` FOR UPDATE";
	 $resp2 = mysqli_query($conn,$sql2);
	 
	  if(!$resp2){
		echo "Rollback: select sum fallita";
		mysqli_rollback($conn);
	}  
	if (mysqli_num_rows($resp2)== 0){
		echo "Rollback: nessuna risposta ricevuta per sum";
		mysqli_rollback($conn);

	}
	$row2 = mysqli_fetch_array($resp2, MYSQLI_NUM);
    $sum = $row2[0];
	$n=  $row2[1];
	
	if((180-$sum)<$value){
		if($sum==180){
			return false;
		}
	$sql3 = "SELECT `Email`,`Durata_assegnata` FROM `Utenti_Consul` WHERE `Email`<>'".$username."' ORDER BY `Inizio_assegnato` FOR UPDATE";
	$resp3 = mysqli_query($conn,$sql3);
	 
	  if(!$resp3){
		echo "Rollback: select email fallita";
		mysqli_rollback($conn);
		
	}  
	if (mysqli_num_rows($resp2)== 0){
		echo "Rollback: nessuna risposta ricevuta per email";
		mysqli_rollback($conn);
		
	}
$fine=0;	
$nuova_sum=0;
		for($i=0;$i<$n;$i++){
		$tmp = mysqli_fetch_array($resp3, MYSQLI_NUM);
		if($i==0 || $fine==0){
			$inizio='14:00:00';
		}
		else{
			$inizio=$fine;
		}
		if($tmp[1]!=0){
			$nuova_durata=(int)($tmp[1]/($sum+$value)*180);
			$nuova_sum+=$nuova_durata;
			$secs=$nuova_durata*60;
			 $fine = date("H:i:s",strtotime($inizio)+$secs);
	$over=date('s',strtotime($fine));
	if($over>=30){
		$fine = date("H:i",strtotime($fine)+60);
	}
	else{
		$fine = date("H:i",strtotime($fine));
	}
	
			$sql="UPDATE `Utenti_Consul` set `Durata_assegnata`='".$nuova_durata."',`Inizio_assegnato`='".$inizio."',`Fine_assegnata`='".$fine."' WHERE `Email`='".$tmp[0]."'";
				 $resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
		
	}

		}
		}
	
	
	$inizio=$fine;
	$nuova_durata=180-$nuova_sum;
	$secs=$nuova_durata*60;
    $fine = date("H:i:s",strtotime($inizio)+$secs);
	$over=date('s',strtotime($fine));
	if($over>=30){
		$fine = date("H:i",strtotime($fine)+60);
	}
	else{
		$fine = date("H:i",strtotime($fine));
	}
	
	
	$sql="UPDATE `Utenti_Consul` set `Durata_richiesta`='".$value."', `Durata_assegnata`='".$nuova_durata."',`Inizio_assegnato`='".$inizio."',`Fine_assegnata`='".$fine."' WHERE `Email`='".$username."'";
		$resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
	}  
	
	
	}
	else{
		 $sql1 = "SELECT MAX(`Fine_assegnata`) FROM `Utenti_Consul` FOR UPDATE";
	 $resp1 = mysqli_query($conn,$sql1);
	 
	  if(!$resp1){
		mysqli_rollback($conn);
		echo "Rollback: select max fallita";
	}  
	if (mysqli_num_rows($resp1)== 0){
    	mysqli_rollback($conn);
		echo "Rollback: nessuna risposta ricevuta per max";
	}
	$row1 = mysqli_fetch_array($resp1, MYSQLI_NUM);
    $res1 = $row1[0];
	$inizio=$res1;
	$secs=$value*60;
    $fine = date("H:i:s",strtotime($inizio)+$secs);
	$over=date('s',strtotime($fine));
	if($over>=30){
		$fine = date("H:i",strtotime($fine)+60);
	}
	else{
		$fine = date("H:i",strtotime($fine));
	}
	
		$sql="UPDATE `Utenti_Consul` set `Durata_richiesta`='".$value."', `Durata_assegnata`='".$value."',`Inizio_assegnato`='".$inizio."',`Fine_assegnata`='".$fine."' WHERE `Email`='".$username."'";
		$resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
	}  
	}

	}
	
		if(!mysqli_commit($conn)){
		mysqli_rollback($conn);
		echo "commit fallita";
		
	}
		mysqli_close($conn); 
		return true;
		
}

function deleteRichiesta($username){
$conn=dbConnect();
$username=sanitizeString($username);
 mysqli_autocommit($conn,false);
	$sql1="SELECT `Email`, `Durata_richiesta` FROM `Utenti_Consul` WHERE `Email`<>'".$username."' and `Durata_assegnata`<>'0' ORDER BY `Inizio_assegnato` FOR UPDATE";
		 $resp1 = mysqli_query($conn,$sql1);
    if(!$resp1){
	 	mysqli_rollback($conn);
		echo "select email fallita";
	}
	
	if (mysqli_num_rows($resp1)!= 0){
   
	$sql="UPDATE `Utenti_Consul` set `Durata_richiesta`='0',`Durata_assegnata`='0', `Inizio_assegnato`='00:00:00',`Fine_assegnata`='00:00:00' ";
		 $resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
	}  
	
	for($i=0;$i<mysqli_num_rows($resp1);$i++){
	$row1 = mysqli_fetch_array($resp1, MYSQLI_NUM);
	$value=$row1[1];
	$username=$row1[0];
	
	if($i==0){
	if($value<59){
			$fine="'14:".$value.":00'";
		}
		else{
			$ore=(int)$value/60;
				$ore=14+$ore;
				$minuti=(int)$value%60;
				$fine="'".$ore.":".$minuti.":00'";
			
		}
		$sql="UPDATE `Utenti_Consul` set `Durata_richiesta`='".$value."',`Durata_assegnata`='".$value."', `Inizio_assegnato`='14:00:00',`Fine_assegnata`=".$fine." WHERE `Email`='".$username."'";
		 $resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
	}  
	$inizio=$fine;
	}
	
	else{
	$sql2 = "SELECT SUM(`Durata_assegnata`),COUNT(`Durata_assegnata`) FROM `Utenti_Consul` FOR UPDATE";
	 $resp2 = mysqli_query($conn,$sql2);
	 
	  if(!$resp2){
		echo "Rollback: select sum fallita";
		mysqli_rollback($conn);
	}  
	if (mysqli_num_rows($resp2)== 0){
		echo "Rollback: nessuna risposta ricevuta per sum";
		mysqli_rollback($conn);

	}
	$row2 = mysqli_fetch_array($resp2, MYSQLI_NUM);
    $sum = $row2[0];
	$n=  $row2[1];
	
	if((180-$sum)<$value){
		if($sum==180){
			return false;
		}
	$sql3 = "SELECT `Email`,`Durata_assegnata` FROM `Utenti_Consul` WHERE `Email`<>'".$username."' ORDER BY `Inizio_assegnato` FOR UPDATE";
	$resp3 = mysqli_query($conn,$sql3);
	 
	  if(!$resp3){
		echo "Rollback: select email fallita";
		mysqli_rollback($conn);
		
	}  
	if (mysqli_num_rows($resp2)== 0){
		echo "Rollback: nessuna risposta ricevuta per email";
		mysqli_rollback($conn);
		
	}
$fine=0;	
$nuova_sum=0;
		for($i=0;$i<$n;$i++){
		$tmp = mysqli_fetch_array($resp3, MYSQLI_NUM);
		if($i==0 || $fine==0){
			$inizio='14:00:00';
		}
		else{
			$inizio=$fine;
		}
		if($tmp[1]!=0){
			$nuova_durata=(int)($tmp[1]/($sum+$value)*180);
			$nuova_sum+=$nuova_durata;
			$secs=$nuova_durata*60;
			 $fine = date("H:i:s",strtotime($inizio)+$secs);
	$over=date('s',strtotime($fine));
	if($over>=30){
		$fine = date("H:i",strtotime($fine)+60);
	}
	else{
		$fine = date("H:i",strtotime($fine));
	}
	
			$sql="UPDATE `Utenti_Consul` set `Durata_assegnata`='".$nuova_durata."',`Inizio_assegnato`='".$inizio."',`Fine_assegnata`='".$fine."' WHERE `Email`='".$tmp[0]."'";
				 $resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
		
	}

		}
		}
	
	
	$inizio=$fine;
	$nuova_durata=180-$nuova_sum;
	while((int)($nuova_durata+$nuova_sum)>180){
		$nuova_durata--;
	}
	$secs=$nuova_durata*60;
    $fine = date("H:i:s",strtotime($inizio)+$secs);
	$over=date('s',strtotime($fine));
	if($over>=30){
		$fine = date("H:i",strtotime($fine)+60);
	}
	else{
		$fine = date("H:i",strtotime($fine));
	}
	
	
	$sql="UPDATE `Utenti_Consul` set `Durata_richiesta`='".$value."', `Durata_assegnata`='".$nuova_durata."',`Inizio_assegnato`='".$inizio."',`Fine_assegnata`='".$fine."' WHERE `Email`='".$username."'";
		$resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
	}  
	
	
	}
	else{
		 $sql1 = "SELECT MAX(`Fine_assegnata`) FROM `Utenti_Consul` FOR UPDATE";
	 $resp1 = mysqli_query($conn,$sql1);
	 
	  if(!$resp1){
		mysqli_rollback($conn);
		echo "Rollback: select max fallita";
	}  
	if (mysqli_num_rows($resp1)== 0){
    	mysqli_rollback($conn);
		echo "Rollback: nessuna risposta ricevuta per max";
	}
	$row1 = mysqli_fetch_array($resp1, MYSQLI_NUM);
    $res1 = $row1[0];
	$inizio=$res1;
	$secs=$value*60;
    $fine = date("H:i:s",strtotime($inizio)+$secs);
	$over=date('s',strtotime($fine));
	if($over>=30){
		$fine = date("H:i",strtotime($fine)+60);
	}
	else{
		$fine = date("H:i",strtotime($fine));
	}
	
		$sql="UPDATE `Utenti_Consul` set `Durata_richiesta`='".$value."', `Durata_assegnata`='".$value."',`Inizio_assegnato`='".$inizio."',`Fine_assegnata`='".$fine."' WHERE `Email`='".$username."'";
		$resp = mysqli_query($conn,$sql);
    if(!$resp){
		echo("Error in query: ".$sql."<br>".mysqli_error($conn));
		mysqli_rollback($conn);
	}  
	}
	}
	}
	}
	
		if(!mysqli_commit($conn)){
		mysqli_rollback($conn);
		echo "commit fallita";
		
	}
	
	    mysqli_close($conn);
	
}


function logout(){
	  $_SESSION=array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600*24,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();  
	RedirectToHome();
 }
 
 function check_https(){
	 
	if ( (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] !== 'off')))  {
// La richiesta e' stata fatta su HTTPS
} else {
// Redirect su HTTPS
$redirect = 'https://' . $_SERVER['HTTP_HOST'] .
$_SERVER['REQUEST_URI'];
header('HTTP/1.1 301 Moved Permanently');
header('Location: ' . $redirect);
exit();
}

 }
 
 function check_cookies(){
  if(!(isset($_COOKIE['s239774_check_cookie']))){
	 header ('HTTP/1.1 307 temporary redirect');
	 header	("Location: check_cookie.php") ;
 }
 }
 
 
