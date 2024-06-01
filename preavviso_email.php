<?php

require_once('database.php');

$db = new Database();

$preavvisi = $db->execute_query(
    "SELECT UTENTI.EMAIL, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE AS TIPO FROM AUTORIZZAZIONI
    INNER JOIN VEICOLI ON AUTORIZZAZIONI.ID_VEICOLO = VEICOLI.ID
    INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
    INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE
    WHERE DATEDIFF(AUTORIZZAZIONI.FINE, NOW()) = 1");

foreach ($preavvisi as $preavviso) {
    $email = $preavviso['EMAIL'];
    $targa = $preavviso['TARGA'];
    $modello = $preavviso['MODELLO'];
    $tipo = $preavviso['TIPO'];
    $oggetto = "Preavviso";
    $messaggio = "Attenzione!!! Tra una settinana la tua autorizzazione per il veicolo targato $targa $modello scadrà.";
    $headers = "From: noreply@5bia.it\r\n";
    $headers .= "Reply-To: noreply@5bia.it\r\n";
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

    if(mail($email, $oggetto, $messaggio, $headers)) {
        echo "Email inviata";
    }
    else{
        echo "Errore nell'invio dell'email";
    }
}
?>