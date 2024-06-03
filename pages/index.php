<?php
$auto_presenti = Database::query("SELECT COUNT(*) AS C FROM ACCESSI_VEICOLO WHERE USCITA IS NULL")->fetch_assoc()['C'];
$autorizzazioni_attive = Database::query("SELECT COUNT(*) AS C FROM AUTORIZZAZIONI WHERE NOW() BETWEEN INIZIO AND FINE AND STATO_RICHIESTA = 1")->fetch_assoc()['C'];
$richieste_pendenti = Database::query("SELECT COUNT(*) AS C FROM AUTORIZZAZIONI WHERE STATO_RICHIESTA IS NULL")->fetch_assoc()['C'];
$posti_occupati = Database::query("SELECT COUNT(*) AS C FROM ACCESSI_VEICOLO WHERE USCITA IS NULL")->fetch_assoc()['C'];

Components::heading("Dashboard", "fas fa-retweet", "Aggiorna", "", "btn btn-outline-primary");
?>


<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Auto presenti</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $auto_presenti ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Autorizzazioni attive</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $autorizzazioni_attive ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Riempimento parcheggio
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $posti_occupati ?></div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Autorizzazione pendenti</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $richieste_pendenti ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
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
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                    <?php include(__DIR__ . '/../components/charts/chart-area.php') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
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
                    "SELECT RUOLI.DESCRIZIONE AS RUOLO, COUNT(*) AS C
                    FROM RUOLI
                    INNER JOIN UTENTI ON UTENTI.ID_RUOLO = RUOLI.ID
                    INNER JOIN VEICOLI ON VEICOLI.ID_UTENTE = UTENTI.ID
                    GROUP BY RUOLI.DESCRIZIONE", "RUOLO", "C") ?>
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