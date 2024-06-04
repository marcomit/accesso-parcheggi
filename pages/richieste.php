<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    updateRequestStatus($_POST['id_richiesta'], $_POST['stato']);
}
function updateRequestStatus($id, $stato) {
    $stato = $_POST['stato'] === 'SI' ? 1 : 0;

    $id = $_POST['id_richiesta'];
    $result = Database::query("UPDATE AUTORIZZAZIONI SET STATO_RICHIESTA = $stato WHERE ID = $id");

    if(!$result){
        return "Errore durante l'aggiornamento dello stato della richiesta";
    }
}
$query = "SELECT AUTORIZZAZIONI.ID, AUTORIZZAZIONI.INIZIO, AUTORIZZAZIONI.FINE, AUTORIZZAZIONI.STATO_RICHIESTA, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE, UTENTI.NOME, UTENTI.COGNOME, RUOLI.DESCRIZIONE
    FROM AUTORIZZAZIONI
    INNER JOIN VEICOLI ON AUTORIZZAZIONI.ID_VEICOLO = VEICOLI.ID
    INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
    INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE
    INNER JOIN RUOLI ON RUOLI.ID = UTENTI.ID_RUOLO
    WHERE AUTORIZZAZIONI.STATO_RICHIESTA IS NULL";

if ($_SESSION['user']['RUOLO'] !== "ADMIN") {
    $query .= " AND UTENTI.ID = " . intval($_SESSION['user']['ID']);
}
$autorizzazioni = Database::query($query);

Components::heading("Richieste", "fas fa-plus text-white-50 fa-sm", "Invia richiesta", "index.php?page_id=5", "btn btn-primary");
?>
<script>showToast("Richieste", "Inserimento avvenuto")</script>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Richieste</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Stato</th>
                        <?php if($_SESSION['user']['RUOLO'] === "ADMIN"):?> <th>Utente</th> <?php endif ?>
                        <th>Veicolo</th>
                        <th>Inizio</th>
                        <th>Fine</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($autorizzazione = $autorizzazioni->fetch_assoc()): ?>
                        <tr data-autorizzazione="<?= $autorizzazione['ID'] ?>">
                            <td class="text-primary" data-toggle="modal" data-target="#requestStatus">
                                <a href="index.php?page_id=5&id_richiesta=<?= $autorizzazione['ID'] ?>">Modifica</a>
                            </td>
                            <?php if($_SESSION['user']['RUOLO'] === "ADMIN"):?> <td><?= $autorizzazione['NOME'] . " - " . $autorizzazione['COGNOME'] ?></td> <?php endif ?>
                            <td><?= $autorizzazione['TARGA'] . ' - ' . $autorizzazione['MODELLO'] ?></td>
                            <td><?= date("d M y", strtotime($autorizzazione['INIZIO'])) ?></td>
                            <td><?= date("d M y", strtotime($autorizzazione['FINE'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>