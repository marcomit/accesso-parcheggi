<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    include('database.php');
    
    $db = new Database();
    $result = $db->execute_query("SELECT UTENTI.ID, UTENTI.NOME, UTENTI.COGNOME, UTENTI.TELEFONO, UTENTI.EMAIL, UTENTI.CODICE_FISCALE, RUOLI.DESCRIZIONE AS RUOLO FROM UTENTI INNER JOIN RUOLI ON UTENTI.ID_RUOLO = RUOLI.ID WHERE EMAIL = '" . $_POST['email'] . "' AND PASSWORD = '" . hash('sha256', $_POST['password']) . "' LIMIT 1");
    
    if ($result->num_rows === 1){
        session_start();
        $_SESSION['user'] = $result->fetch_assoc();
        $db->execute_query("INSERT INTO ACCESSI_UTENTE(ID_UTENTE) VALUES (" . $_SESSION['user']['ID'] . ")");
    }
    else{
        $errorLogin = "Nome utente o password errati";     
    }
    //
    if ($errorLogin == ''){
        header('Location: index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="IT-it">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestione parcheggio ITT "Leonardo da Vinci - Viterbo"</title>
    <link rel="apple-touch-icon" href="https://cdn.argoweb.net/img/favicon.jpg">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <form action="login.php" method="POST">
        <div class="container">
    
            <!-- Outer Row -->
            <div class="row justify-content-center">
    
                <div class="p-4">
                    <div class="card o-hidden border-0 shadow-lg my-4 p-5 w-20">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="my-3 text-center">
                            <img src="img/logo.png" alt="Logo" class="" style="max-width: 120px;">
                            </div>
                            <div class="row">
                                    <div class="my-2 mx-auto">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4 font-weight-bold">Gestione Accessi - Accedi</h1>
                                            
                                        </div>
                                        <?php if (isset($errorLogin)): ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $errorLogin; ?>
                                        </div>
                                        <?php elseif (isset($_SESSION['user'])): ?>
                                            <div class="alert alert-success" role="alert">
                                                Autenticazione effettuata...
                                            </div>
                                            <script type="text/javascript">
                                                setTimeout(() => document.location.href = "index.php", 3);
                                            </script>
                                        <?php endif; ?>
                                        <form class="user">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                                    placeholder="Indirizzo mail...">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Ricordami</label>
                                                </div>
                                            </div>
                                            <input type="submit" class="btn btn-primary btn-user btn-block" value="ACCEDI" />
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.php">Password Dimenticata</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="register.php">Crea un account</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
    
            </div>
    
        </div>
    </form>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>