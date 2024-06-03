<?php

if(isset($_POST['email'])){

    include('database.php');
	$errore=0; //variabile di controllo errori (se rimane a 0 non ci sono errori)
	
	if($_POST['email']==""){
		$errore=1;
	}else{
        
		$result= Database::query("SELECT UTENTI.ID AS Id, UTENTI.PASSWORD AS Password FROM UTENTI WHERE email='".$_POST['email']."' limit 1");
		if($result->num_rows === 1){
            $row = $result -> fetch_assoc();
			//l’hash ci servirà per recuperare i dati utente e confermare la richiesta
			//la password nel database si presume criptata, con md5 o altro algoritmo
			//al posto di questi due dati, se ne possono usare altri legati all’utente, purché univoci
			$hash=hash('sha256', $row['Password'].$row['Id']);
		}else
			$errore=1;
		
	}	
	
	//se non ci sono stati errori, invio l’email all’utente con il link da confermare
	if($errore==0){
		
		$header= "From: 5bia.it <noreply@5bia.it>\n";
		$header .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
		$header .= "Content-Transfer-Encoding: 7bit\n\n";
						
		$subject= "5bia.it - Nuova password utente";
		
		$mess_invio="<html><body>";
		
		$mess_invio.="
		Clicca sul <a href=\"http://www.5bia.it/nuova_password.php?hash=".$hash."\">link</a> per confermare la nuova password.<br />
		Se il link non è visibile, copia la riga qui sotto e incollala sul tuo browser: <br />
		http://www.5bia.it/nuova_password.php?hash=".$hash."
		";
		
		$mess_invio.='</body><html>';
		
		//invio email
		if(@mail($_POST['email'], $subject, $mess_invio, $header)){
			unset($_POST); //elimino le variabili post, in modo che non appaiano nel form
		}
	
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
<?php if(!isset($_POST['email'])): ?>
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
                                        <p class="mb-4 text-center">Inserisci l'indirizzo mail
                                            <br>riceverai le istruzioni per il ripristino della password</p>
                                    
                                    <form class="user" action="forgot-password.php" method="post">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Inserisci indirizzo mail...">
                                        </div>
                                        <input class="btn btn-primary btn-rounded" type="submit" value="Ripristina Password">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Crea un account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Hai già un account? Accedi</a>
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <?php else: ?>
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
                                        <h1 class="h4 text-gray-900 mb-2 text-center">Controlla la tua mail</h1>
                                        <p class="mb-4 text-center">Controlla la tua casella mail</p>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Crea un account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Hai già un account? Accedi</a>
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