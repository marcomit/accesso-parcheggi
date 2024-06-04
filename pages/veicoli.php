<?php
$query = "SELECT v.ID, v.TARGA, v.MODELLO, tv.DESCRIZIONE AS TIPO, u.EMAIL AS UTENTE, v.SALVATO, u2.NOME AS ADMIN_NOME, u2.COGNOME AS ADMIN_COGNOME
FROM VEICOLI v
INNER JOIN TIPI_VEICOLO tv ON tv.ID = v.ID_TIPO
INNER JOIN UTENTI u ON u.ID = v.ID_UTENTE
LEFT JOIN UTENTI u2 ON u2.ID = v.ID_ADMIN";

if($_SESSION['user']['RUOLO'] !== "ADMIN"){
    $query .= " WHERE v.ID_UTENTE = " . $_SESSION['user']['ID'];
}

$veicoli = Database::query($query);

Components::heading("Veicoli", "fas fa-plus", "Aggiungi veicolo", "index.php?page_id=7", "btn btn-primary") ?>

<div class="container mt-5">
<h1>Veicoli</h1>
<table class="table table-bordered" id="dataTable">
    <thead>
        <tr>
            <th>Attivato da</th>
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
                <td><a href="index.php?page_id=7&id_veicolo=<?= $veicolo['ID'] ?>"><?= $veicolo['SALVATO'] == 1 ? $veicolo['ADMIN_NOME'] . " " . $veicolo['ADMIN_COGNOME'] : "Non attivo" ?></a></td>
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







                