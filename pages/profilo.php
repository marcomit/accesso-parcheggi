<?php
require_once('database.php');
$db = new Database();
$profilo = $db->execute_query("SELECT RUOLI.DESCRIZIONE AS Ruolo, UTENTI.NOME AS Nome, UTENTI.COGNOME AS Cognome, UTENTI.EMAIL AS Email, UTENTI.CODICE_FISCALE AS CF, UTENTI.TELEFONO AS Telefono FROM UTENTI, RUOLI 
WHERE UTENTI.ID_RUOLO = RUOLI.ID AND UTENTI.ID = " . $_SESSION['user']['ID'])->fetch_assoc();

$initials = strtoupper(substr($profilo['Nome'], 0, 1) . substr($profilo['Cognome'], 0, 1));
?>

<style>
    .profile-initials {
        width: 100px;
        height: 100px;
        background-color: #6c757d;
        color: white;
        font-size: 40px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto;
    }
</style>

<div class="d-flex justify-content-center align-items-center py-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <div class="dropdown no-arrow">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="p-3">Profilo <br>personale</h1>
                    <div class="profile-initials"><?php echo $initials; ?></div>
                </div>
                <div class="card p-3" style="font-size: 20px">
                    <p><strong>Nome: </strong><?php echo $profilo['Nome']; ?></p>
                    <br>
                    <p><strong>Cognome: </strong><?php echo $profilo['Cognome']; ?></p>
                    <br>
                    <p><strong>Codice Fiscale: </strong><?php echo $profilo['CF']; ?></p>
                    <br>
                    <p><strong>Numero di telefono: </strong><?php echo $profilo['Telefono']; ?></p>
                    <br>
                    <p><strong>Email: </strong><?php echo $profilo['Email']; ?></p>
                    <br>
                    <p><strong>Ruolo: </strong><?php echo $profilo['Ruolo']; ?></p>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
