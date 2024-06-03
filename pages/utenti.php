<?php
if($_SESSION['user']['RUOLO'] === "ADMIN")
{
    if(isset($_POST['ruolo']) & isset($_POST['utente'])){ 
      Database::query("UPDATE UTENTI SET UTENTI.ID_RUOLO = ".$_POST['ruolo']." WHERE ID = ".$_POST['utente']."");
    }
    $utenti = Database::query("SELECT RUOLI.DESCRIZIONE AS Ruolo, UTENTI.ID AS ID, UTENTI.NOME AS Nome, UTENTI.COGNOME AS Cognome, UTENTI.EMAIL AS Email, UTENTI.CODICE_FISCALE AS CF, UTENTI.TELEFONO AS Telefono FROM UTENTI JOIN RUOLI ON UTENTI.ID_RUOLO = RUOLI.ID");
}
else{
    http_response_code(404);
    include('404.html');
    exit;
}
?> 
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifica Ruolo</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group" method="POST" action="">
                        <select name="ruolo" class="py-2 form-select form-control form-control-user" aria-label="Default select example">
                        <?php 
                        $SelezioneRuoli = Database::query("SELECT RUOLI.ID AS ID, RUOLI.DESCRIZIONE AS Ruolo FROM RUOLI");
                                while($Ruolo = $SelezioneRuoli->fetch_assoc()):
                            ?>
                                <option name="ruolo" value="<?= $Ruolo["ID"]?>"><?= $Ruolo["Ruolo"]?></option>
                            <?php endwhile; ?>   
                        </select>
                        
                        <input type="hidden" value="" id="utente" name="utente" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Annulla</button>
                    <input class="btn btn-primary" type="submit" value="Modifica"/>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Page Heading -->

<?php if($_SESSION['user']['RUOLO'] === "ADMIN"): ?> 
<div class="container mt-5">

<h1>Lista Utenti <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm p-2" data-toggle="modal" data-target="#logoutModal">Modifica Ruolo</a>
</h1>

<table class="table table-bordered" id="dataTable">
    <thead>
        <tr>
            <th data-sort="Ruolo">Ruolo</th>
            <th data-sort="Nome">Nome</th>
            <th data-sort="Cognome">Cognome</th>
            <th data-sort="Email">Email</th>
            <th data-sort="CF">CF</th>
            <th data-sort="Telefono">Telefono</th>
        </tr>
    </thead>
    <tbody>
        <?php while($utente = $utenti->fetch_assoc()): ?>
            <tr>
                <td><input class="text-center" type="radio" onclick="assegnaValore(this.value)" name="utente" value="<?= $utente['ID']?>"/>
                <?php echo ($utente['Ruolo']); ?></td>
                <td><?php echo ($utente['Nome']); ?></td>
                <td><?php echo ($utente['Cognome']); ?></td>
                <td><?php echo ($utente['Email']); ?></td>
                <td><?php echo ($utente['CF']); ?></td>
                <td><?php echo ($utente['Telefono']); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<?php endif?> 
<script>
    function assegnaValore(valore){
        document.getElementById('utente').value = valore;
    }
</script>