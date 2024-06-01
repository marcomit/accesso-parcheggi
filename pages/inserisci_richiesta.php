<?php
require_once(__DIR__ . '/../database.php');

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // AGGIORNA O INSERISCE LA RICHIESTA
    if(isset($_GET['id_autorizzazione'])){
        // AGGIORNA RICHIESTA
        $db->execute_query(
            "UPDATE AUTORIZZAZIONI 
            SET INIZIO = '" . $_POST['startDate'] . "', FINE = '" . $_POST['endDate'] . "', ID_VEICOLO = '" . $_POST['vehicle'] . "' WHERE ID = " . $_GET['id_autorizzazione']
        );
    }
    else {
        // INSERISCE RICHIESTA
        $db->execute_query(
            "INSERT INTO AUTORIZZAZIONI (INIZIO, FINE, ID_VEICOLO, STATO_RICHIESTA)
            VALUES ('" . $_POST['startDate'] . "', '" . $_POST['endDate'] . "', '" . $_POST['vehicle'] . "', 0)"
        );
    }
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

if(isset($_GET['id_autorizzazione'])) {
    $autorizzazione = $db->execute_query(
        "SELECT AUTORIZZAZIONI.INIZIO, AUTORIZZAZIONI.FINE, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE AS TIPO
        FROM AUTORIZZAZIONI
        INNER JOIN VEICOLI ON AUTORIZZAZIONI.ID_VEICOLO = VEICOLI.ID
        INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
        INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE
        WHERE AUTORIZZAZIONI.ID = " . $_GET['id_autorizzazione'] . 
        ($_SESSION['user']['RUOLO'] !== "ADMIN" ? " AND UTENTI.ID = " . $_SESSION['user']['ID'] : "") 
    );
}
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Crea richiesta</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Richieste</h6>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="startDate">Data Inizio</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
            </div>
            <div class="form-group">
                <label for="endDate">Data Fine</label>
                <input type="date" class="form-control" id="endDate" name="endDate" required>
            </div>
            <div class="form-group">
                <label for="vehicle">Seleziona il Veicolo</label>
                <select class="form-control" id="vehicle" name="vehicle" required>
                    <option value="">Seleziona un veicolo</option>
                    <?php 
                    $veicoli = $db->execute_query(
                        "SELECT VEICOLI.ID, VEICOLI.TARGA, VEICOLI.MODELLO FROM VEICOLI
                        WHERE VEICOLI.ID_UTENTE = " . $_SESSION['user']['ID']
                    );
                    while($veicolo = $veicoli->fetch_assoc()): ?>
                        <option value="<?= $veicolo['ID'] ?>"><?= $veicolo['TARGA'] . ' - ' . $veicolo['MODELLO'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Invia</button>
        </form>
    </div>
</div>



