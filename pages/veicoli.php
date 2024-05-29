<?php
require_once(__DIR__ . '/../database.php');
$db = new Database();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $targa = $_POST['targa'];
    $modello = $_POST['modello'];
    $tipologia = $_POST['tipologia'];
    $db->execute_query("INSERT INTO VEICOLI(TARGA, MODELLO, ID_TIPO, ID_UTENTE) VALUES ('$targa', '$modello', '$tipologia', " . $_SESSION['user']['ID'] . ")");
}

$veicoli_personali = $db->execute_query(
    "SELECT VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE, AUTORIZZAZIONI.INIZIO, AUTORIZZAZIONI.FINE FROM VEICOLI " . 
    "INNER JOIN AUTORIZZAZIONI ON VEICOLI.ID = AUTORIZZAZIONI.ID_VEICOLO " . 
    "INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO " .
    "INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE WHERE UTENTI.ID = " . $_SESSION['user']['ID']);

if($_SESSION['user']['RUOLO'] == "ADMIN"){
    $veicoli_totali = $db->execute_query(
        "SELECT VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE, AUTORIZZAZIONE.INIZIO, AUTORIZZAZIONE.FINE, AUTORIZZAZIONE.STATO_RICHIESTA, UTENTI.EMAIL FROM VEICOLI " .
        "INNER JOIN AUTORIZZAZIONI ON VEICOLI.ID = AUTORIZZAZIONI.ID_VEICOLO ".
        "INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO ".
        "INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE");
}
?>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aggiungi veicolo</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="targa" class="form-control form-control-user"
                            id="targa" aria-describedby="targa"
                            placeholder="Targa" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="modello" class="form-control form-control-user"
                            id="modello" placeholder="Modello" required>
                    </div>
                    <div class="form-group">
                        <select name="tipologia" class="form-select form-control form-control-user" aria-label="Default select example">
                            <?php 
                                $tipologie = $db->execute_query("SELECT * FROM TIPI_VEICOLO");
                                while($tipologia = $tipologie->fetch_assoc()):
                            ?>
                                <option value="<?= $tipologia["ID"] ?>"><?= $tipologia["DESCRIZIONE"] ?></option>
                            <?php endwhile; ?>
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


<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Veicoli</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#logoutModal"><i
            class="fas fa-plus fa-sm text-white-50"></i> Aggiungi veicolo</a>
</div>

<?php if($_SESSION['user']['RUOLO'] == 'ADMIN'): ?>
    <?php while($veicolo = $veicoli_totali->fetch_assoc()): ?>
        
    <?php endwhile; ?>
<?php else: ?>
    <h2>prrr</h2>
<?php endif ?>