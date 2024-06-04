<?php

$id_veicolo = $_GET['id_veicolo'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // AGGIORNA O INSERISCE LA RICHIESTA
    if(isset($id_veicolo)){
        // AGGIORNA RICHIESTA
        if($_SESSION['user']['RUOLO'] === "ADMIN" && isset($_POST['status'])) {
            $result = Database::query(
                "UPDATE VEICOLI
                SET SALVATO = '" . $_POST['status'] . "', ID_ADMIN = '" . $_SESSION['user']['ID'] . "'  WHERE ID = " . $id_veicolo
            );
        }
        else{
            $result = Database::query(
                "UPDATE VEICOLI
                SET TARGA = '" . $_POST['targa'] . "', MODELLO = '" . $_POST['modello'] . "', ID_TIPO = '" . $_POST['tipo'] . "' WHERE ID = " . $id_veicolo
            );
        }
    }
    else {
        // INSERISCE RICHIESTA
        $result = Database::query(
            "INSERT INTO VEICOLI (TARGA, MODELLO, ID_TIPO, ID_UTENTE)
            VALUES ('" . $_POST['targa'] . "', '" . $_POST['modello'] . "', '" . $_POST['tipo'] . "', '" . $_SESSION['user']['ID'] . "')"
        );

    }
    if($result): ?>
    <script>
        window.location.href = "index.php?page_id=6";
    </script>
    <?php endif; 
}

$richiesta_valida = true;
$disabled = false;

if(isset($id_veicolo)) {
    $veicolo = Database::query(
        "SELECT UTENTI.ID AS UTENTE, VEICOLI.ID, VEICOLI.TARGA, VEICOLI.MODELLO, VEICOLI.SALVATO, TIPI_VEICOLO.ID AS TIPO, TIPI_VEICOLO.DESCRIZIONE AS TIPOLOGIA
        FROM VEICOLI
        INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE
        INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
        WHERE VEICOLI.ID = " . $id_veicolo . 
        ($_SESSION['user']['RUOLO'] !== "ADMIN" ? " AND VEICOLI.ID_UTENTE = " . $_SESSION['user']['ID'] : "") . 
        " LIMIT 1"
    );
    if($veicolo->num_rows === 0) $richiesta_valida = false;
    else {
        $veicolo = $veicolo->fetch_assoc();
        if($veicolo['SALVATO'] == 1 || ($veicolo['UTENTE'] !== $_SESSION['user']['ID'] && $_SESSION['user']['RUOLO'] === "ADMIN")){
            $disabled = true;
        }
    }

}

if($richiesta_valida):
Components::heading((isset($id_veicolo) ? "Aggiorna" : "Inserisci") . " veicolo") ?>
<div class="card shadow mb-4 w-75 mx-auto">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Richieste</h6>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="targa">Targa</label>
                <input type="text" placeholder="AA000AA" class="form-control" value="<?= isset($id_veicolo) ? $veicolo['TARGA'] : "" ?>" 
                id="targa" name="targa" required <?= $disabled ? "disabled" : "" ?>>
            </div>
            <div class="form-group">
                <label for="modello">Modello</label>
                <input type="text" placeholder="Ferrari..." class="form-control" value="<?= isset($id_veicolo) ? $veicolo['MODELLO'] : "" ?>"
                id="modello" name="modello" required <?= $disabled ? "disabled" : "" ?>>
            </div>
            <div class="form-group">
                <label for="tipo">Veicolo</label>
                <select class="form-control" id="tipo" name="tipo" required <?= $disabled ? "disabled" : "" ?>>
                    <?php if($disabled): ?>
                        <option value="<?= $veicolo['TIPO'] ?>"><?= $veicolo['TIPOLOGIA'] ?></option>
                    <?php else: ?>
                        <option value="">Seleziona il tipo del veicolo</option>
                        <?php $tipologie = Database::query("SELECT * FROM TIPI_VEICOLO");
                        while($tipologia = $tipologie->fetch_assoc()): ?>
                            <option value="<?= $tipologia['ID'] ?>"
                                <?= isset($id_veicolo) && $tipologia['ID'] === $veicolo['TIPO'] ? 'selected' : '' ?>>
                                <?= $tipologia['DESCRIZIONE'] ?>
                            </option>
                    <?php endwhile; endif; ?>
                </select>
            </div>
            <?php if($disabled && $_SESSION['user']['RUOLO'] === "ADMIN"): ?>
                <div class="form-group">
                    <label for="status">Stato</label>
                    <select name="status" id="status" class="form-select form-control form-control-user" aria-label="Default select example" required>
                        <option value="">Seleziona lo stato della richiesta</option>
                        <option value="1">ATTIVA</option>
                    </select>
                </div>
            <?php endif ?>
            <a href="<?= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/" ?>" class="btn btn-outline-danger">Annulla</a>
            <button type="<?= $disabled && $_SESSION['user']['RUOLO'] !== "ADMIN" ? "button" : "submit" ?>" class="btn btn-primary"><?= isset($id_veicolo) ? "Aggiorna" : "Inserisci" ?></button>
        </form>
    </div>
</div>
<?php else: Components::not_found(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "/", "500", "Richiesta inesistente o non hai i permessi per modificarla."); endif?>