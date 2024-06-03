<?php
$query = "SELECT VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE AS TIPO, UTENTI.EMAIL AS UTENTE FROM VEICOLI
INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE";

if($_SESSION['user']['RUOLO'] !== "ADMIN"){
    $query .= " WHERE VEICOLI.ID_UTENTE = " . $_SESSION['user']['ID'];
}

$veicoli = Database::query($query);

Components::heading("Veicoli", "fas fa-plus", "Aggiungi veicolo", "index.php?page_id=5", "btn btn-primary") ?>

<div class="container mt-5">
<h1>Veicoli</h1>
<table class="table table-bordered" id="dataTable">
    <thead>
        <tr>
            <th data-sort="Targhe">Targhe</th>
            <th data-sort="Modelli">Modelli</th>
            <th data-sort="ID_Tipo">Tipo</th>
            <?php if($_SESSION['user']['RUOLO']==="ADMIN"): ?>
                <th data-sort="ID_Utente">Utente</th>
            <?php endif; ?>
            
            
        </tr>
    </thead>
    <tbody>
        <?php while($veicolo = $veicoli->fetch_assoc()): ?>
            <tr>
                <td><?= $veicolo['TARGA'] ?></td>
                <td><?= $veicolo['MODELLO'] ?></td>
                <td><?= $veicolo['TIPO'] ?></td>
                <?php if($_SESSION['user']['RUOLO']==="ADMIN"): ?>
                    <td><?= $veicolo['UTENTE'] ?></td>
                <?php endif; ?>
                
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>







                