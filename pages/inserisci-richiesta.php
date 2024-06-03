<?php

$id_richiesta = $_GET['id_richiesta'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // AGGIORNA O INSERISCE LA RICHIESTA
    if(isset($id_richiesta)){
        // AGGIORNA RICHIESTA
        if($_SESSION['user']['RUOLO'] === "ADMIN" && isset($_POST['status'])) {
            $result = Database::query(
                "UPDATE AUTORIZZAZIONI
                SET STATO_RICHIESTA = '" . $_POST['status'] . "' WHERE ID = " . $id_richiesta
            );
        }
        else{
            $result = Database::query(
                "UPDATE AUTORIZZAZIONI 
                SET INIZIO = '" . $_POST['startDate'] . "', FINE = '" . $_POST['endDate'] . "', ID_VEICOLO = '" . $_POST['vehicle'] . "' WHERE ID = " . $id_richiesta
            );
        }
    }
    else {
        // INSERISCE RICHIESTA
        $result = Database::query(
            "INSERT INTO AUTORIZZAZIONI (INIZIO, FINE, ID_VEICOLO)
            VALUES ('" . $_POST['startDate'] . "', '" . $_POST['endDate'] . "', '" . $_POST['vehicle'] . "')"
        );

    }
    if($result): ?>
    <script>
        window.location.href = "index.php?page_id=3";
    </script>
    <?php endif; 
}

$richiesta_valida = true;
$disabled = false;

if(isset($id_richiesta)) {
    $autorizzazione = Database::query(
        "SELECT RUOLI.DESCRIZIONE AS RUOLO, UTENTI.EMAIL, UTENTI.ID, VEICOLI.ID AS VEICOLO, AUTORIZZAZIONI.INIZIO, AUTORIZZAZIONI.FINE, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE AS TIPO
        FROM AUTORIZZAZIONI
        INNER JOIN VEICOLI ON AUTORIZZAZIONI.ID_VEICOLO = VEICOLI.ID
        INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
        INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE
        INNER JOIN RUOLI ON RUOLI.ID = UTENTI.ID_RUOLO
        WHERE AUTORIZZAZIONI.ID = " . $id_richiesta . 
        ($_SESSION['user']['RUOLO'] !== "ADMIN" ? " AND UTENTI.ID = " . $_SESSION['user']['ID'] : "") . 
        " LIMIT 1"
    );
    if($autorizzazione->num_rows === 0) $richiesta_valida = false;
    else {
        $autorizzazione = $autorizzazione->fetch_assoc();
        if($autorizzazione['ID'] !== $_SESSION['user']['ID'] && $_SESSION['user']['RUOLO'] === "ADMIN"){
            $disabled = true;
        }
    }

}

if($richiesta_valida):
Components::heading((isset($id_richiesta) ? "Aggiorna" : "Inserisci") . " richiesta") ?>
<div class="card shadow mb-4 w-75 mx-auto">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Richieste</h6>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="startDate">Data Inizio</label>
                <input type="date" class="form-control" value="<?= isset($id_richiesta) ? date_format(new DateTime($autorizzazione['INIZIO']), 'Y-m-d') : "" ?>" 
                id="startDate" name="startDate" required <?= $disabled ? "disabled" : "" ?>>
            </div>
            <div class="form-group">
                <label for="endDate">Data Fine</label>
                <input type="date" class="form-control" value="<?= isset($id_richiesta) ? date_format(new DateTime($autorizzazione['FINE']), 'Y-m-d') : "" ?>"
                id="endDate" name="endDate" required <?= $disabled ? "disabled" : "" ?>>
            </div>
            <div class="form-group">
                <label for="vehicle">Veicolo</label>
                <select class="form-control" id="vehicle" name="vehicle" required <?= $disabled ? "disabled" : "" ?>>
                    <?php if($disabled): ?>
                        <option value="<?= $autorizzazione['VEICOLO'] ?>"><?= $autorizzazione['TIPO'] .' - ' . $autorizzazione['TARGA'] . ' - ' . $autorizzazione['MODELLO'] ?></option>
                    <?php else: ?>
                        <option value="">Seleziona un veicolo</option>
                        <?php $veicoli = Database::query("SELECT VEICOLI.ID, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE AS TIPO FROM VEICOLI
                        INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
                        WHERE VEICOLI.ID_UTENTE = " . $_SESSION['user']['ID']);
                        while($veicolo = $veicoli->fetch_assoc()): ?>
                            <option value="<?= $veicolo['ID'] ?>"
                                <?= isset($id_richiesta) && $autorizzazione['VEICOLO'] === $veicolo['ID'] ? 'selected' : '' ?>>
                                <?= $veicolo['TIPO'] . ' - ' . $veicolo['TARGA'] . ' - ' . $veicolo['MODELLO'] ?>
                            </option>
                    <?php endwhile; endif; ?>
                </select>
            </div>
            <?php if($disabled): ?>
                <div class="form-group">
                    <label for="status">Stato</label>
                    <select name="status" id="status" class="form-select form-control form-control-user" aria-label="Default select example" required>
                        <option value="">Seleziona lo stato della richiesta</option>
                        <option value="1">ACCETTA</option>
                        <option value="0">RIFIUTA</option>
                    </select>
                </div>
            <?php endif ?>
            <a href="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/" ?>" class="btn btn-outline-danger">Annulla</a>
            <button type="submit" class="btn btn-primary"><?= isset($id_richiesta) ? "Aggiorna" : "Inserisci" ?></button>
        </form>
    </div>
</div>
<?php else: Components::not_found(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/", "500", "Richiesta inesistente o non hai i permessi per modificarla."); endif?>