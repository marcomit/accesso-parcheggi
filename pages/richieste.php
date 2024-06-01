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

$autorizzazioni = $db->execute_query(
    "SELECT AUTORIZZAZIONI.ID, AUTORIZZAZIONI.INIZIO, AUTORIZZAZIONI.FINE, AUTORIZZAZIONI.STATO_RICHIESTA, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE, UTENTI.NOME, UTENTI.COGNOME, RUOLI.DESCRIZIONE
    FROM AUTORIZZAZIONI
    INNER JOIN VEICOLI ON AUTORIZZAZIONI.ID_VEICOLO = VEICOLI.ID
    INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
    INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE
    INNER JOIN RUOLI ON RUOLI.ID = UTENTI.ID_RUOLO
    WHERE AUTORIZZAZIONI.STATO_RICHIESTA IS NULL");
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
                        <?php if($_SESSION['user']['RUOLO'] === "ADMIN"):?> <th>Utente</th> <?php endif ?>
                        <th>Veicolo</th>
                        <th>Inizio</th>
                        <th>Fine</th>
                        <th>Stato</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($autorizzazione = $autorizzazioni->fetch_assoc()): ?>
                        <tr>
                            <input type="hidden" value="<?= $autorizzazione['ID'] ?>">
                            <?php if($_SESSION['user']['RUOLO'] === "ADMIN"):?> <td><?= $autorizzazione['NOME'] . " - " . $autorizzazione['COGNOME'] ?></td> <?php endif ?>
                            <td><?= $autorizzazione['TARGA'] . ' - ' . $autorizzazione['MODELLO'] ?></td>
                            <td><?= date("d M y", strtotime($autorizzazione['INIZIO'])) ?></td>
                            <td><?= date("d M y", strtotime($autorizzazione['FINE'])) ?></td>
                            <td class="text-primary" data-toggle="modal" data-target="#requestStatus">
                                <?= $autorizzazione['STATO_RICHIESTA'] == null ? 'Pendente' : ($autorizzazione['STATO_RICHIESTA'] ? 'Accettata' : 'Rifiutata') ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php if($_SESSION['user']['RUOLO'] === "ADMIN"):?>
<div class="modal fade" id="requestStatus" tabindex="-1" role="dialog" aria-labelledby="requestStatusTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestStatusTitle">Aggiorna stato richiesta</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_richiesta" id="id_richiesta" value=""/>
                    <div class="form-group">
                        <select name="stato" class="form-select form-control form-control-user" aria-label="Default select example">
                            <option value="">Seleziona lo stato della richiesta</option>
                            <option value="SI">ACCETTA</option>
                            <option value="NO">RIFIUTA</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                    <input class="btn btn-primary" type="submit" value="Inserisci"/>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif ?>