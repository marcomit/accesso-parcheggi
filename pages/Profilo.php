<?php
require_once('database.php');
$db = new Database();
$profilo = $db->execute_query("SELECT RUOLI.DESCRIZIONE AS Ruolo, UTENTI.NOME AS Nome, UTENTI.COGNOME AS Cognome, UTENTI.EMAIL AS Email, UTENTI.CODICE_FISCALE AS CF, UTENTI.TELEFONO AS Telefono FROM UTENTI, RUOLI 
WHERE UTENTI.ID_RUOLO = RUOLI.ID AND UTENTI.ID = " . $_SESSION['user']['ID'])->fetch_assoc();
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="text-center">Profilo - <?php echo $profilo['Nome']; ?> <?php echo $profilo['Cognome']; ?></h1>
</div>
<div class="card" style="font-size: 20px">
    <p> <strong>Nome: </strong><?php echo $profilo['Nome']; ?></p>
    <br>
    <p><strong>Cognome: </strong><?php echo $profilo['Cognome']; ?></p>
    <br>
    <p><strong>Codice Fiscale: </strong><?php echo $profilo['CF']; ?></p>
    <br>
    <p><strong>Numero di telefono: </strong><?php echo $profilo['Telefono']; ?></p>
    <br>
    <p><strong>Email: </strong><?php echo $profilo['Email']; ?></p>
    <br>
    <p> <strong>Ruolo: </strong><?php echo $profilo['Ruolo']; ?></p>
    <br>
    </div>
</div>
</div>