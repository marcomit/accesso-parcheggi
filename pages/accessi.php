<?php
$query = "SELECT VEICOLI.TARGA AS Targa, VEICOLI.MODELLO AS Modello, ACCESSI_VEICOLO.ENTRATA AS Entrata, ACCESSI_VEICOLO.USCITA AS Uscita, UTENTI.NOME AS Nome, UTENTI.COGNOME AS Cognome FROM VEICOLI
INNER JOIN ACCESSI_VEICOLO ON ACCESSI_VEICOLO.ID_VEICOLO = VEICOLI.ID
INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE";

if($_SESSION['user']['RUOLO']!=="ADMIN"){
    $query .= " WHERE UTENTI.ID = " . intval($_SESSION['user']['ID']);
}

$accessi = Database::query($query);
Components::heading("Accessi", "fas fa-download fa-sm text-white-50", "Generate Report", "index.php?page_id=4", "btn btn-primary")
?>
<div class="container mt-5">
<h1>Accessi</h1>
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
                <td><?= $accesso['Entrata'] ?></td>
                <td><?= $accesso['Uscita'] ?></td>
                <td><?= $accesso['Targa'] ?></td>
                <td><?= $accesso['Modello'] ?></td>
                <?php if($_SESSION['user']['RUOLO']==="ADMIN"):?>
                        <td><?= $accesso['Nome'] ?></td>
                        <td><?= $accesso['Cognome'] ?></td>
                <?php endif;?>
                
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>