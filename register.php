<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $error_registration = validateRegistration();
}
function validateRegistration(): string {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat-password'];
    $fiscal_code = $_POST['fiscal-code'];
    $telephone = $_POST['phone'];

    if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)){
        return 'The password must contain at least one uppercase letter, one lowercase letter, one number and one special character';
    }

    if(!preg_match('/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/', $fiscal_code)){
        return 'The fiscal code is not valid';
    }   
    
    if(!preg_match('/^(\+39|0039)?\s?(\d{2,4})\s?[\d\s-]{6,10}$/', $telephone)){
        return 'The phone number is not valid';
    }

    if($password !== $repeat_password){
        return 'The passwords do not match';
    }

    include('database.php');   
    
    $db = new Database();
    
    if($db->execute_query("SELECT *FROM UTENTI WHERE EMAIL = '$email' LIMIT 1")->num_rows > 0){
        return "This email is already registered!";
    }

    $result = $db->execute_query(
        "INSERT INTO UTENTI(NOME, COGNOME, EMAIL, PASSWORD, CODICE_FISCALE, TELEFONO, ID_RUOLO)
        VALUES ('$first_name', '$last_name', '$email', '" . hash("sha256", $password) . "', '$fiscal_code', '$telephone', 1)");

    if(!$result){
        return "C'è stato un errore nell'inserimento dei dati!";
    }
    header('Location: login.php');
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

    <title>SB Admin 2 - Register</title>

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

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <?php if(isset($error_registration)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $error_registration; ?>
                                </div>
                            <?php endif ?>
                            <form class="user" method="POST" action="register.php">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="firstName" name="first-name"
                                            placeholder="First Name" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="last-name" name="last-name"
                                            placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email" name="email"
                                        placeholder="Email Address" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="password" name="password" placeholder="Password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="repeatPassword" name="repeat-password" placeholder="Repeat Password" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="fiscalCode" name="fiscal-code"
                                            placeholder="Codice fiscale" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="tel" class="form-control form-control-user" id="phone" name="phone"
                                            placeholder="Telefono" required>
                                    </div>
                                </div>
                                <input type="submit" value="Register Account" class="btn btn-primary btn-user btn-block"/>
                                <hr>
                                <a href="index.php" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.php" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>