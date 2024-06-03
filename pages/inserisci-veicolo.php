<?php
require_once(__DIR__ . '/../database.php');
$db = new Database();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $targa = $_POST['targa'];
    $modello = $_POST['modello'];
    $tipologia = $_POST['tipologia'];
    $db->execute_query("INSERT INTO VEICOLI(TARGA, MODELLO, ID_TIPO, ID_UTENTE) VALUES ('$targa', '$modello', '$tipologia', " . $_SESSION['user']['ID'] . ")");
}
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Aggiungi veicolo</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Veicolo</h6>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="targa">Targa</label>
                <input type="text" name="targa" class="form-control form-control-user"
                    id="targa" aria-describedby="targa"
                    placeholder="AA000AA" required>
            </div>
            <div class="form-group">
                <label for="modello">Modello</label>
                <input type="text" name="modello" class="form-control form-control-user"
                    id="modello" placeholder="Modello della macchina" required>
            </div>
            <div class="form-group">
                <label for="tipologia">Tipologia</label>
                <select name="tipologia" class="form-select form-control form-control-user" aria-label="Default select example">
                    <?php 
                        $tipologie = $db->execute_query("SELECT * FROM TIPI_VEICOLO");
                        while($tipologia = $tipologie->fetch_assoc()):
                    ?>
                        <option value="<?= $tipologia["ID"] ?>"><?= $tipologia["DESCRIZIONE"] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Aggiungi</button>
        </form>
    </div>
</div>