
<?php
require_once(__DIR__ . "/../database.php");

$db = new Database();

// VISUALIZZA TUTTE LE AUTORIZZAZIONI
$autorizzazioni = $db->execute_query(
    "SELECT AUTORIZZAZIONI.ID, AUTORIZZAZIONI.INIZIO, AUTORIZZAZIONI.FINE, AUTORIZZAZIONI.STATO_RICHIESTA, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE AS TIPO, UTENTI.NOME, UTENTI.COGNOME, RUOLI.DESCRIZIONE AS RUOLO
    FROM AUTORIZZAZIONI
    INNER JOIN VEICOLI ON AUTORIZZAZIONI.ID_VEICOLO = VEICOLI.ID
    INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
    INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE
    INNER JOIN RUOLI ON RUOLI.ID = UTENTI.ID_RUOLO
    WHERE AUTORIZZAZIONI.STATO_RICHIESTA = 1");// RICHIESTE AUTORIZZATE
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Autorizzazioni</h1>
    <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-retweet fa-sm text-white-50"></i> Aggiorna</a>
</div>

<?php if($autorizzazioni->num_rows == 0): ?>
    <div><h2>Non hai nessuna autorizzazione attiva</h2></div>
<?php else: ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Autorizzazioni</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <?php if($_SESSION['user']['RUOLO'] == 'ADMIN'): ?><th>Utente</th><?php endif; ?>
                            <th>Inizio</th>
                            <th>Fine</th>
                            <th>Targa</th>
                            <th>Modello</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        <?php while($autorizzazione = $autorizzazioni->fetch_assoc()): ?>
                            <tr data-toggle="modal" data-target="#cambioRichiesta">
                                <?php if($_SESSION['user']['RUOLO'] == 'ADMIN'): ?>
                                    <td><?= $autorizzazione['NOME'] . " " . $autorizzazione['COGNOME'] . " - " . $autorizzazione['RUOLO'] ?></td>
                                <?php endif; ?>
                                <td><?= date("d M y", strtotime($autorizzazione['INIZIO'])) ?></td>
                                <td><?= date("d M y", strtotime($autorizzazione['FINE'])) ?></td>
                                <td><?= $autorizzazione['TARGA'] ?></td>
                                <td><?= $autorizzazione['MODELLO'] ?></td>
                                <td><?= $autorizzazione['TIPO'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>