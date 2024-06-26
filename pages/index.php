<?php
$POSTI_TOTALI = 120;

$auto_presenti = Database::query("SELECT COUNT(*) AS C FROM ACCESSI_VEICOLO WHERE USCITA IS NULL")->fetch_assoc()['C'];
$autorizzazioni_attive = Database::query("SELECT COUNT(*) AS C FROM AUTORIZZAZIONI WHERE NOW() BETWEEN INIZIO AND FINE AND STATO_RICHIESTA = 1")->fetch_assoc()['C'];
$richieste_pendenti = Database::query("SELECT COUNT(*) AS C FROM AUTORIZZAZIONI WHERE STATO_RICHIESTA IS NULL")->fetch_assoc()['C'];

Components::heading("Dashboard", "fas fa-retweet", "Aggiorna", "", "btn btn-outline-primary");
?>

<div class="row">
    <?php
    Components::card("Posti liberi", $POSTI_TOTALI - $auto_presenti, "fa-car");
    Components::card("Autorizzazioni attive", $autorizzazioni_attive, "fa-video", "success");
    Components::card("Riempimento parcheggio", $auto_presenti . "%", "fa-bars-progress", "info", intval($auto_presenti * 100 / $POSTI_TOTALI));
    Components::card("Autorizzazioni pendenti", $richieste_pendenti, "fa-inbox", "warning");
     ?>
</div>

<div class="mt-5"></div>
<?php Components::heading("Grafici di oggi") ?>

<div class="row">
    <div class="col-xl-7 col-lg-7">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Accessi per ora</h6>
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
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="todayBarChart"></canvas>
                    <?= Chart::bar("todayBarChart",
                    "SELECT HOUR(ENTRATA) AS H, COUNT(*) AS C
                    FROM ACCESSI_VEICOLO
                    WHERE DAY(ENTRATA) = DAY(NOW())
                    GROUP BY HOUR(ENTRATA)
                    ORDER BY HOUR(ENTRATA)", "H", "C", "Accessi",
                    function ($key){
                        if($key < 9){
                            return "0" . $key . ":00";
                        }
                        return $key . ":00";
                    }) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Accessi per ruolo</h6>
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
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="pie-chart"></canvas>
                    <?php Chart::pie("pie-chart",
                    "SELECT RUOLI.DESCRIZIONE AS RUOLO, COUNT(ACCESSI_VEICOLO.ID) AS C
                    FROM RUOLI
                    LEFT JOIN UTENTI ON UTENTI.ID_RUOLO = RUOLI.ID
                    LEFT JOIN VEICOLI ON VEICOLI.ID_UTENTE = UTENTI.ID
                    LEFT JOIN ACCESSI_VEICOLO ON ACCESSI_VEICOLO.ID_VEICOLO = VEICOLI.ID
                    WHERE DAY(ACCESSI_VEICOLO.ENTRATA) = DAY(NOW())
                    GROUP BY RUOLI.ID, RUOLI.DESCRIZIONE
                    ORDER BY RUOLI.DESCRIZIONE", "RUOLO", "C") ?>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Studenti
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Docenti
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Personale
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Altro
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5"></div>
<?php Components::heading("Grafici generali") ?>

<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Accessi per ruolo</h6>
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
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="generalPieChart"></canvas>
                    <?php Chart::pie("generalPieChart",
                    "SELECT RUOLI.DESCRIZIONE AS RUOLO, COUNT(ACCESSI_VEICOLO.ID) AS C
                    FROM RUOLI
                    LEFT JOIN UTENTI ON UTENTI.ID_RUOLO = RUOLI.ID
                    LEFT JOIN VEICOLI ON VEICOLI.ID_UTENTE = UTENTI.ID
                    LEFT JOIN ACCESSI_VEICOLO ON ACCESSI_VEICOLO.ID_VEICOLO = VEICOLI.ID
                    GROUP BY RUOLI.ID, RUOLI.DESCRIZIONE
                    ORDER BY RUOLI.DESCRIZIONE", "RUOLO", "C") ?>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Studenti
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Docenti
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Personale
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Altro
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Accessi per ora</h6>
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
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="generalAreaChart"></canvas>
                    <?= Chart::area("generalAreaChart", 
                    "SELECT HOUR(USCITA) AS H, COUNT(*) AS C
                    FROM ACCESSI_VEICOLO
                    WHERE USCITA IS NOT NULL
                    GROUP BY HOUR(USCITA)
                    ORDER BY HOUR(USCITA)", "H", "C", "Accessi",
                    function ($key){
                        if($key < 9){
                            return "0" . $key . ":00";
                        }
                        return $key . ":00";
                    }) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5"></div>
<?php Components::heading("Posti parcheggio") ?>

<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Accessi per ora</h6>
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
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="parkingAreaChart"></canvas>
                    <?= Chart::area("parkingAreaChart", 
                    "SELECT HOUR(USCITA) AS H, COUNT(*) AS C
                    FROM ACCESSI_VEICOLO
                    WHERE USCITA IS NOT NULL
                    GROUP BY HOUR(USCITA)
                    ORDER BY HOUR(USCITA)", "H", "C", "Accessi",
                    function ($key){
                        if($key < 9){
                            return "0" . $key . ":00";
                        }
                        return $key . ":00";
                    }) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Accessi per ruolo</h6>
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
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="parkingPieChart"></canvas>
                    <?php Chart::pie("parkingPieChart",
                    "SELECT RUOLI.DESCRIZIONE AS RUOLO, COUNT(ACCESSI_VEICOLO.ID) AS C
                    FROM RUOLI
                    LEFT JOIN UTENTI ON UTENTI.ID_RUOLO = RUOLI.ID
                    LEFT JOIN VEICOLI ON VEICOLI.ID_UTENTE = UTENTI.ID
                    LEFT JOIN ACCESSI_VEICOLO ON ACCESSI_VEICOLO.ID_VEICOLO = VEICOLI.ID
                    GROUP BY RUOLI.ID, RUOLI.DESCRIZIONE
                    ORDER BY RUOLI.DESCRIZIONE", "RUOLO", "C") ?>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Studenti
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Docenti
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Personale
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Altro
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5"></div>
<?php Components::heading("Autorizzazioni") ?>

<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Autorizzazioni attive in base ai ruoli</h6>
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
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="authorizationBarChart"></canvas>
                    <?= Chart::bar("authorizationBarChart", 
                    "SELECT RUOLI.DESCRIZIONE AS RUOLO, COUNT(AUTORIZZAZIONI.ID) AS C
                    FROM RUOLI
                    LEFT JOIN UTENTI ON UTENTI.ID_RUOLO = RUOLI.ID
                    LEFT JOIN VEICOLI ON VEICOLI.ID_UTENTE = UTENTI.ID
                    LEFT JOIN AUTORIZZAZIONI ON AUTORIZZAZIONI.ID_VEICOLO = VEICOLI.ID 
                    WHERE AUTORIZZAZIONI.STATO_RICHIESTA = 1 AND NOW() BETWEEN AUTORIZZAZIONI.INIZIO AND AUTORIZZAZIONI.FINE
                    GROUP BY RUOLI.ID, RUOLI.DESCRIZIONE
                    ORDER BY RUOLI.DESCRIZIONE", "RUOLO", "C", "Autorizzazioni") ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Accessi per ruolo</h6>
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
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="authorizationPieChart"></canvas>
                    <?php Chart::pie("authorizationPieChart",
                    "SELECT RUOLI.DESCRIZIONE AS RUOLO, COUNT(ACCESSI_VEICOLO.ID) AS C
                    FROM RUOLI
                    LEFT JOIN UTENTI ON UTENTI.ID_RUOLO = RUOLI.ID
                    LEFT JOIN VEICOLI ON VEICOLI.ID_UTENTE = UTENTI.ID
                    LEFT JOIN ACCESSI_VEICOLO ON ACCESSI_VEICOLO.ID_VEICOLO = VEICOLI.ID
                    GROUP BY RUOLI.ID, RUOLI.DESCRIZIONE
                    ORDER BY RUOLI.DESCRIZIONE", "RUOLO", "C") ?>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> Studenti
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Docenti
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-info"></i> Personale
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Altro
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php //$initials = strtoupper(substr($profilo['Nome'], 0, 1) . substr($profilo['Cognome'], 0, 1));?>
<style>
    .profile-initials {
        width: 100px;
        height: 100px;
        background-color: #6c757d;
        color: white;
        font-size: 40px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto;
    }
</style>