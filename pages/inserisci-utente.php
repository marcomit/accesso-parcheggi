<?php
include('../database.php');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = $_POST['Nome'];
    $cognome = $_POST['Cognome'];
    $ruolo = $_POST['Ruolo'];
    $telefono = $_POST['NTelefono'];
    $email = $_POST['Email'];
    $cf = $_POST['CF'];
    $password = hash('sha256',$_POST['password']);
    
    $query = "INSERT INTO UTENTI (NOME, COGNOME, ID_RUOLO, TELEFONO, EMAIL, CODICE_FISCALE, PASSWORD)
              VALUES ('$nome', '$cognome', '$ruolo', '$telefono', '$email', '$cf', '$password')";
    
    if(Database::query($query)){
        ?>
        <script>
        window.location.href = "index.php?page_id=1";
        </script>
        <?php
    } else {
        ?>
         <script>
        // JavaScript generato da PHP
        var message = "<?php echo "errore nell'inserimento"?>";
        alert(message);
    </script>
    <?php
    }
}
?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Aggiungi Utente</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Utente</h6>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Nome">Nome</label>
                        <input type="text" name="Nome" class="form-control form-control-user"
                            id="Nome" aria-describedby="Nome" required>
                    </div>
                    <div class="form-group">
                        <label for="Cognome">Cognome</label>
                        <input type="text" name="Cognome" class="form-control form-control-user"
                            id="Cognome" required>
                    </div>
                    <div class="form-group">
                        <label for="Ruolo">Ruolo</label>
                        <select name="Ruolo" class="form-select form-control form-control-user" aria-label="Default select example">
                            <?php 
                                $ruoli = Database::query("SELECT * FROM RUOLI");
                                while($ruolo = $ruoli->fetch_assoc()):
                            ?>
                                <option value="<?= $ruolo["ID"] ?>"><?= $ruolo["DESCRIZIONE"] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-user"
                            id="password" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Telefono">Numero di telefono</label>
                        <input type="tel" name="NTelefono" class="form-control form-control-user"
                            id="Telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="mail" name="Email" class="form-control form-control-user"
                            id="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="CF">Codice Fiscale</label>
                        <input type="text" name="CF" class="form-control form-control-user"
                            id="CF" required>
                    </div>
                    
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Aggiungi</button>
        </form>
    </div>
</div>
