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
	Database::connect();

	$password=random(8); //nuova password di 8 caratteri
	
	//controllo che i valori dell’hash corrispondano ai valori salvati nel database
	$result=Database::query("SELECT UTENTI.ID AS ID, UTENTI.PASSWORD FROM UTENTI");
	
	if($result->num_rows === 1){ 
	
		while($utente = $result->fetch_assoc()){
			$hash_utente = $utente['password'].$utente['id'];
			if($hash_utente === $hash){
				$db2 = new Database();
				$updateQuery = $db2 -> execute_query("UPDATE UTENTI SET UTENTI.PASSWORD='".hash('sha256', $password)."' WHERE UTENTI.ID=".$$utente['id']." and UTENTI.PASSWORD='".$utente['password']."'");
				break;
			}
			
		}
		
		//salvo la nuova password al posto della vecchia (in md5)
		$header= "From: 5bia.it <noreply@5bia.it>\n";
		$header .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
		$header .= "Content-Transfer-Encoding: 7bit\n\n";
						
		$subject= "5bia.it - Nuova password utente";
		
		$mess_invio="<html><body>";
		
		$mess_invio.="
		La sua nuova password utente è " . $password."<br />
		Ora puoi accedere all'area <a href=\"http://www.5bia.it/login.php\" style=\"color: red\">Login</a>.
		";
		
		$mess_invio.='</body><html>';
		

		if(@mail($email, $subject, $mess_invio, $header)){?>
			La password è stata cambiata con successo. Controlla la tua email.<br /><br /> 
			<?php
		}
	
	}

	

}

?>