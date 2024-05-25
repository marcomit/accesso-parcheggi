<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    include('database.php');
    
    $db = new Database();
    $result = $db->execute_query("SELECT UTENTI.NOME, UTENTI.COGNOME, UTENTI.TELEFONO, UTENTI.EMAIL, UTENTI.CODICE_FISCALE, RUOLI.DESCRIZIONE AS RUOLO FROM UTENTI INNER JOIN RUOLI ON UTENTI.ID_RUOLO = RUOLI.ID WHERE EMAIL = '" . $_POST['email'] . "' AND PASSWORD = '" . hash('sha256', $_POST['password']) . "' LIMIT 1");
    
    // NEL FRATTEMPO FINTO CONTROLLO
    if ($result->num_rows === 1){
        session_start();
        $_SESSION['user'] = $result->fetch_assoc();
    }else{
        $errorLogin = "Nome utente o password errati";     
    }
    //
    if ($errorLogin == ''){
        header('Location: index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

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
    
                <div class="col-xl-10 col-lg-12 col-md-9">
    
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <?php
                                        if(!isset($errorLogin)){

                                        }
                                        else if ($errorLogin !== ''){
                                        ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $errorLogin; ?>
                                        </div>
                                        <?php    
                                        }else if (isset($_SESSION['user'])){
                                            ?>
                                            <div class="alert alert-success" role="alert">
                                                Autenticazione effettuata...
                                            </div>
                                            <script type="text/javascript">
                                                setTimeout(() => document.location.href = "index.php", 3);
                                            </script>
                                            <?php
                                        }
                                        ?>
                                        <form class="user">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address...">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-user"
                                                    id="exampleInputPassword" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <input type="submit" class="btn btn-primary btn-user btn-block" value="ACCEDI" />
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="register.php">Create an Account!</a>
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