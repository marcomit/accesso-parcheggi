<?php
include("database.php");
Database::connect();

//il controllo del get evita errori di pagina

if(isset($_POST['password']) & isset($_POST['hash'])){
	$hash= $_POST['hash'];
	$password = $_POST['password'];
	$result=Database::query("SELECT UTENTI.ID AS ID, UTENTI.PASSWORD AS password FROM UTENTI");
	if($result->num_rows === 1){ 
		while($utente = $result->fetch_assoc()){
			$hash_utente = hash('sha256', $utente['password'].$utente['ID']);
			if($hash_utente === $hash){
				$updateQuery = Database::query("UPDATE UTENTI SET UTENTI .PASSWORD='".hash('sha256', $password)."' WHERE UTENTI.ID=".$utente['ID']." and UTENTI.PASSWORD='".$utente['password']."'");
				break;
			}
		}
	}
} ?>

<?php if(isset($_GET['hash'])): ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestione parcheggio ITT "Leonardo da Vinci - Viterbo"</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

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
                                        <h1 class="h4 text-gray-900 mb-2 text-center">Password Dimenticata?</h1>
                                        <p class="mb-4 text-center">Inserisci la nuova password
                                            <br></p>
                                    
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Inserisci password...">
                                        </div>
                                        <input type="hidden" value="<?$_GET['hash']?>">
                                        <input class="btn btn-primary btn-rounded" type="submit" value="Ripristina Password">
                                    </form>
                                    <hr>
                                </div>
                            
                        </div>
                    </div>
                </div>

            </div>
		</div>
	</div>	

    <?php endif; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>