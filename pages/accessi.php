<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Accessi</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>
<?php
require_once(__DIR__ . '/../database.php');
$db = new Database();
if($_SESSION['user']['RUOLO']==="ADMIN"){
    $accessi = $db->execute_query(
        "SELECT VEICOLI.TARGA AS Targa, VEICOLI.MODELLO AS Modello, ACCESSI_VEICOLO.ENTRATA AS Entrata, ACCESSI_VEICOLO.USCITA AS Uscita, UTENTI.NOME AS Nome, UTENTI.COGNOME AS Cognome FROM VEICOLI
        INNER JOIN ACCESSI_VEICOLO ON ACCESSI_VEICOLO.ID_VEICOLO = VEICOLI.ID
        INNER JOIN UTENTI ON UTENTI.ID=VEICOLI.ID_UTENTE");
}
else{
    $Utente=$_SESSION['user']['ID'];
    $accessi = $db->execute_query(
        "SELECT VEICOLI.TARGA AS Targa, VEICOLI.MODELLO AS Modello, ACCESSI_VEICOLO.ENTRATA AS Entrata, ACCESSI_VEICOLO.USCITA AS Uscita FROM VEICOLI
        INNER JOIN ACCESSI_VEICOLO ON ACCESSI_VEICOLO.ID_VEICOLO = VEICOLI.ID
        INNER JOIN UTENTI ON UTENTI.ID=VEICOLI.ID_UTENTE WHERE UTENTI.ID=$Utente");
}

?>
<div class="container mt-5">
<h1>Veicoli</h1>
<table class="table table-bordered" id="dataTable">
    <thead>
        <tr>
        <?php if($_SESSION['user']['RUOLO']==="ADMIN"):?>
            <th data-sort="Entrata">Entrata</th>
            <th data-sort="Uscita">Uscita</th>
            <th data-sort="Targa">Targa</th>
            <th data-sort="Modello">Modello</th>
            <th data-sort="Nome">Nome</th>
            <th data-sort="Cognome">Cognome</th>
            <?php else:?>
                <th data-sort="Entrata">Entrata</th>
                <th data-sort="Uscita">Uscita</th>
                <th data-sort="Targa">Targa</th>
                <th data-sort="Modello">Modello</th>
        <?php endif;?>
            
        </tr>
    </thead>
    <tbody>
        <?php while($accesso = $accessi->fetch_assoc()): ?>
            <tr>
                <?php if($_SESSION['user']['RUOLO']==="ADMIN"):?>
                        <td><?= $accesso['Entrata'] ?></td>
                        <td><?= $accesso['Uscita'] ?></td>
                        <td><?= $accesso['Targa'] ?></td>
                        <td><?= $accesso['Modello'] ?></td>
                        <td><?= $accesso['Nome'] ?></td>
                        <td><?= $accesso['Cognome'] ?></td>
                        <?php else:?>
                        <td><?= $accesso['Entrata'] ?></td>
                        <td><?= $accesso['Uscita'] ?></td>
                        <td><?= $accesso['Targa'] ?></td>
                        <td><?= $accesso['Modello'] ?></td>
                <?php endif;?>
                
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>