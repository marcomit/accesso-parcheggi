
<?php
$query = "SELECT a.ID, a.INIZIO, a.FINE, a.STATO_RICHIESTA, v.TARGA, v.MODELLO, tv.DESCRIZIONE AS TIPO, u.NOME AS NOME, u.COGNOME AS COGNOME, u2.NOME AS ADMIN_NOME, u2.COGNOME AS ADMIN_COGNOME, r.DESCRIZIONE AS RUOLO
FROM AUTORIZZAZIONI a
INNER JOIN VEICOLI v ON a.ID_VEICOLO = v.ID
INNER JOIN TIPI_VEICOLO tv ON tv.ID = v.ID_TIPO
INNER JOIN UTENTI u ON u.ID = v.ID_UTENTE
INNER JOIN UTENTI u2 ON u2.ID = a.ID_ADMIN
INNER JOIN RUOLI r ON r.ID = u.ID_RUOLO
WHERE a.STATO_RICHIESTA = 1";

if($_SESSION['user']['RUOLO'] !== "ADMIN"){
    $query .= " AND u.ID = " . $_SESSION['user']['ID'];
}
$autorizzazioni = Database::query($query);

Components::heading("Autorizzazioni", "fa fa-retweet", "Aggiorna", "", "btn-outline-primary") ?>

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
                            <th>Autorizzato da</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        <?php while($autorizzazione = $autorizzazioni->fetch_assoc()): ?>
                            <tr>
                                <?php if($_SESSION['user']['RUOLO'] === 'ADMIN'): ?>
                                    <td><?= $autorizzazione['NOME'] . " " . $autorizzazione['COGNOME'] . " - " . $autorizzazione['RUOLO'] ?></td>
                                <?php endif; ?>
                                <td><?= date("d M y", strtotime($autorizzazione['INIZIO'])) ?></td>
                                <td><?= date("d M y", strtotime($autorizzazione['FINE'])) ?></td>
                                <td><?= $autorizzazione['TARGA'] ?></td>
                                <td><?= $autorizzazione['MODELLO'] ?></td>
                                <td><?= $autorizzazione['TIPO'] ?></td>
                                <td><?= $autorizzazione['ADMIN_NOME'] . " " . $autorizzazione['ADMIN_COGNOME'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>