<html lang="en"><head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    
    <link rel="apple-touch-icon" href="https://cdn.argoweb.net/img/favicon.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.0.2/dist/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style type="text/css">/* Chart.js */
@keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}</style><style>
    body {
    font-family: 'Nunito', sans-serif;
  }
  .card {
    margin: 20px 0;
  }
  .card-headers {
    background-color: #4e73df;
    color: white;
  }
  .table-container {
    margin-top: 20px;
  }
  .table th, .table td {
    vertical-align: middle;
  }
</style><style type="text/css">/* Chart.js */
@keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}</style></head>

<?php
require_once(__DIR__ . '/../database.php');
$db = new Database();


// Esegui la query
$result = $db->execute_query('SELECT COUNT(*) AS NumeroPersonale FROM UTENTI WHERE UTENTI.ID_RUOLO = 3');

if ($result) {
    $row = $result->fetch_assoc();
    if ($row && isset($row['NumeroPersonale'])) {
        $numeroPersonale = $row['NumeroPersonale'];
    } else {
        $numeroPersonale = 0; // Valore predefinito se la query non restituisce risultati
    }
} else {
    echo "Errore durante l'esecuzione della query: " . $mysqli->error;
    $numeroPersonale = 0; // Valore predefinito in caso di errore
}

$result1 = $db->execute_query('SELECT COUNT(*) AS NumeroDocenti FROM UTENTI WHERE UTENTI.ID_RUOLO = 2');

if ($result1) {
    $row1 = $result1->fetch_assoc();
    if ($row1 && isset($row1['NumeroDocenti'])) {
        $numeroDocenti = $row1['NumeroDocenti'];
    } else {
        $numeroDocenti = 0; // Valore predefinito se la query non restituisce risultati
    }
} else {
    echo "Errore durante l'esecuzione della query: " . $mysqli->error;
    $numeroDocenti = 0; // Valore predefinito in caso di errore
}

$result2 = $db->execute_query('SELECT COUNT(*) AS NumeroEsterni FROM UTENTI WHERE UTENTI.ID_RUOLO = 1');

if ($result2) {
    $row2 = $result2->fetch_assoc();
    if ($row2 && isset($row2['NumeroEsterni'])) {
        $numeroEsterni = $row2['NumeroEsterni'];
    } else {
        $numeroEsterni = 0; // Valore predefinito se la query non restituisce risultati
    }
} else {
    echo "Errore durante l'esecuzione della query: " . $mysqli->error;
    $numeroEsterni = 0; // Valore predefinito in caso di errore
}
//

$data_oggi = date('Y-m-d');
$result3 = $db->execute_query('SELECT COUNT(*) AS AccessiGiorno FROM ACCESSI_UTENTE WHERE DATE(ACCESSI_UTENTE.DATA) = $data_oggi');

if ($result3) {
    $row3 = $result3->fetch_assoc();
    if ($row3 && isset($row3['AccessiGiorno'])) {
        $accessiGiorno = $row3['AccessiGiorno'];
    } else {
        $accessiGiorno = 0; // Valore predefinito se la query non restituisce risultati
    }
} else {
   
    $accessiGiorno = 0; // Valore predefinito in caso di errore
}

?>
<body id="page-top" class="sidebar-toggled">

    

    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>


    







    

        
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                      

                      <div class="col-md-2">
                        <div class="card text-center">
                            <div class="card-header">Docenti</div>
                            <div class="card-body">
                                <p class="card-text"><?php echo htmlspecialchars((string)$numeroDocenti); ?></p>
                            </div>
                        </div>
                        </div>
                      
                      <div class="col-md-2">
        <div class="card text-center">
            <div class="card-header">Personale</div>
            <div class="card-body">
                <p class="card-text"><?php echo htmlspecialchars((string)$numeroPersonale); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-2">        
    <div class="card text-center">
            <div class="card-header">Esterni</div>
            <div class="card-body">
                <p class="card-text"><?php echo htmlspecialchars((string)$numeroEsterni); ?></p>
            </div>
        </div>
    </div>
                      <div class="col-md-2">
                        <div class="card text-center">
                          <div class="card-headers">Posti disponibili</div>
                          <div class="card-body">
                            <p class="card-text">N</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="card text-center">
                          <div class="card-headers">Posti occupati</div>
                          <div class="card-body">
                            <p class="card-text">N</p>
                          </div>
                        </div>
                      </div>
                    </div>
</div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Percentuale Posti Liberi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="postiLiberiChart" width="500" height="500" style="display: block; box-sizing: border-box; height: 688px; width: 688px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Accessi Totali (Docenti vs Esterni)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <canvas id="accessiTotaliChart" width="500" height="500" style="display: block; box-sizing: border-box; height: 688px; width: 688px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Frequenza di Accessi per Ora</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="frequenzaAccessiChart" width="500" height="200" style="display: block; box-sizing: border-box; height: 344px; width: 688px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  

                  
                  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top" style="display: none;">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>


    

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
    
        
        <link rel="apple-touch-icon" href="https://cdn.argoweb.net/img/favicon.jpg">
    
        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
    
    <style type="text/css">/* Chart.js */
    @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}</style>




    <!-- Page Wrapper -->
    <div id="wrapper">

        <!--?php include("components/navbar.php"); ?-->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            
            
             
            
            
            
            

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top" style="opacity: 0.995006; display: none;">
        <i class="fas fa-angle-up"></i>
    </a>
    
    
    
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>


    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.0.2/dist/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart setup -->
    <script>
        // Percentuale dei Posti Liberi
        var ctx1 = document.getElementById('postiLiberiChart').getContext('2d');
        var postiLiberiChart = new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Posti Liberi', 'Posti Occupati'],
                datasets: [{
                    label: 'Percentuale dei Posti Liberi',
                    data: [30, 70], // Supponiamo che il 30% siano posti liberi e il 70% occupati
                    backgroundColor: ['#4e73df', '#1cc88a'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673'],
                    borderColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%';
                            }
                        }
                    }
                }
            }
        });

        // Accessi Totali nei 7 Giorni
        var ctx2 = document.getElementById('accessiTotaliChart').getContext('2d');
        var accessiTotaliChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Docenti', 'Esterni'],
                datasets: [{
                    label: 'Accessi Totali',
                    data: [600, 400], // Supponiamo che 600 accessi siano dei docenti e 400 degli esterni
                    backgroundColor: ['#36b9cc', '#f6c23e'],
                    hoverBackgroundColor: ['#2c9faf', '#f4b619'],
                    borderColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });

        // Frequenza di Accessi in Giornata
        var ctx3 = document.getElementById('frequenzaAccessiChart').getContext('2d');
        var frequenzaAccessiChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ['08:00 - 09:00', '09:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00', '12:00 - 13:00', '13:00 - 14:00'],
                datasets: [{
                    label: 'Numero di Accessi',
                    data: [50, 75, 100, 150, 125, 80], // Esempio di dati
                    backgroundColor: '#4e73df',
                    hoverBackgroundColor: '#2e59d9',
                    borderColor: '#4e73df'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>





   


</body></html>