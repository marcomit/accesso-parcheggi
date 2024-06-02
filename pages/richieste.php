<?php
require_once(__DIR__ . '/../database.php');
$db = new Database();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    updateRequestStatus($_POST['id_richiesta'], $_POST['stato']);
}
function updateRequestStatus($id, $stato) {
    global $db;
    $stato = $_POST['stato'] === 'SI' ? 1 : 0;

    $id = $_POST['id_richiesta'];
    $result = $db->execute_query("UPDATE AUTORIZZAZIONI SET STATO_RICHIESTA = $stato WHERE ID = $id");

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
$autorizzazioni = $db->execute_query($query);
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Richieste</h1>
    <div>
        <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-retweet fa-sm"></i></a>
        <a href="index.php?page_id=8" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Invia richiesta</a>
    </div>
</div>

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
                                <?php 
                                $stato = $autorizzazione['STATO_RICHIESTA'] == null ? 'Pendente' : ($autorizzazione['STATO_RICHIESTA'] ? 'Accettata' : 'Rifiutata');
                                if($_SESSION['user']['RUOLO'] !== "ADMIN"): ?>
                                    <a href="index.php?page_id=8&id_richiesta=<?= $autorizzazione['ID'] ?>">Modifica</a>
                                <?php else: ?>
                                    <a href="index.php?page_id=8&id_richiesta=<?= $autorizzazione['ID'] ?>">Modifica</a>
                                <?php endif ?>
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