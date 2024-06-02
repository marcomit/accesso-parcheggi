<?php


//funzione che crea una password random
function random($lunghezza=12){
	$caratteri_disponibili ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$codice = "";
	for($i = 0; $i<$lunghezza; $i++){
		$codice = $codice.substr($caratteri_disponibili,rand(0,strlen($caratteri_disponibili)-1),1);
	}
	return $codice;
}



//il controllo del get evita errori di pagina
if(isset($_GET['hash'])){
	
	$hash=$_GET['hash'];
	$id=substr($hash, 32);
	$password_old=substr($hash, 0, 32);

	$password=random(8); //nuova password di 8 caratteri
	
	//controllo che i valori dell’hash corrispondano ai valori salvati nel database
	$result=mysql_query("SELECT * FROM utenti WHERE id=".$id." AND password='".$password_old."'", $db);
	
	if(mysql_num_rows($result)>0){ 
	
		$row=mysql_fetch_array($result);
		$email=$row['email'];
		
		//salvo la nuova password al posto della vecchia (in md5)
		$result=mysql_query("update utenti set password='".md5($password)."' where id=".$id." and password='".$password_old."'", $db);

		$header= "From: sito.it <info@sito.it>\n";
		$header .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
		$header .= "Content-Transfer-Encoding: 7bit\n\n";
						
		$subject= "sito.it - Nuova password utente";
		
		$mess_invio="<html><body>";
		
		$mess_invio.="
		La sua nuova password utente è ".$password."<br />
		Ora puoi accedere all'area <a href=\"http://www.sito.it/login.php\" style=\"color: red\">Login</a>.
		";
		
		$mess_invio.='</body><html>';
		

		if(@mail($email, $subject, $mess_invio, $header)){?>
			La password è stata cambiata con successo. Controlla la tua email.<br /><br /> 
		<?php
		}
	
	}

	

} //if(isset($_GET['hash']))

?>