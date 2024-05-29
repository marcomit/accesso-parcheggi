<?php
require_once(__DIR__ . "/../database.php");



if($_SESSION['user']["RUOLO"] !== "ADMIN"){
  // VISUALIZZA SOLO LE PROPRIE AUTORIZZAZIONI
  $autorizzazioni = (new Database())->execute_query("SELECT UTENTI.NOME, UTENTI.EMAIL, RUOLI.DESCRIZIONE AS RUOLO, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE AS TIPO_VEICOLO, AUTORIZZAZIONI.INIZIO, AUTORIZZAZIONI.FINE FROM AUTORIZZAZIONI 
  INNER JOIN VEICOLI ON VEICOLI.ID = AUTORIZZAZIONI.ID_VEICOLO 
  INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE 
  INNER JOIN RUOLI ON RUOLI.ID = UTENTI.ID_RUOLO 
  INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO
  WHERE UTENTI.ID = " . $_SESSION['user']['ID']);
}
else{
  // VISUALIZZA TUTTE LE AUTORIZZAZIONI
  $autorizzazioni = (new Database())->execute_query("SELECT UTENTI.NOME, UTENTI.EMAIL, RUOLI.DESCRIZIONE AS RUOLO, VEICOLI.TARGA, VEICOLI.MODELLO, TIPI_VEICOLO.DESCRIZIONE AS TIPO_VEICOLO, AUTORIZZAZIONI.INIZIO, AUTORIZZAZIONI.FINE FROM AUTORIZZAZIONI
  INNER JOIN VEICOLI ON VEICOLI.ID = AUTORIZZAZIONI.ID_VEICOLO 
  INNER JOIN UTENTI ON UTENTI.ID = VEICOLI.ID_UTENTE 
  INNER JOIN RUOLI ON RUOLI.ID = UTENTI.ID_RUOLO 
  INNER JOIN TIPI_VEICOLO ON TIPI_VEICOLO.ID = VEICOLI.ID_TIPO");
}
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Autorizzazioni</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Richiedi autorizzazione</a>
</div>

<?php if($autorizzazioni->num_rows == 0): ?>
    <h2>Non hai richiesto nessuna autorizzazione</h2>
<?php else: ?>
<?php while($autorizzazione = $autorizzazioni->fetch_assoc()): ?>
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Accessi</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <p><?= $autorizzazione['NOME'] ?></p>
                <p><?= $autorizzazione['RUOLO'] ?></p>
                <p><?= $autorizzazione['TARGA'] ?></p>
                <p><?= $autorizzazione['TIPO_VEICOLO'] ?></p>
                <p><?= $autorizzazione['INIZIO'] ?></p>
                <p><?= $autorizzazione['FINE'] ?></p>
            </div>
        </div>
    </div>
<?php endwhile; endif; ?>
