<?php
if($_SESSION['user']['RUOLO'] === "ADMIN")
{
    if(isset($_POST['ruolo']) &  isset($_POST['utente'])){ 
      Database::query("UPDATE UTENTI SET UTENTI.ID_RUOLO = ".$_POST['ruolo']." WHERE ID = ".$_POST['utente']."");
    }
    else if(isset($_POST['utente']) & $_POST['fun'] == "DEL")
    {
        Database::query("DELETE FROM UTENTI WHERE UTENTI.ID = ".$_POST['utente'] );
    }
    $utenti = Database::query("SELECT RUOLI.DESCRIZIONE AS Ruolo, UTENTI.ID AS ID, UTENTI.NOME AS Nome, UTENTI.COGNOME AS Cognome, UTENTI.EMAIL AS Email, UTENTI.CODICE_FISCALE AS CF, UTENTI.TELEFONO AS Telefono FROM UTENTI JOIN RUOLI ON UTENTI.ID_RUOLO = RUOLI.ID");
}

if($_SESSION['user']['RUOLO'] === "ADMIN"):
Components::heading("", "fas fa-plus", "Aggiungi Utente", "index.php?page_id=2", "btn btn-primary") ?>
<div class="modal fade" id="Modify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        
                        <input type="hidden" value="" id="idUtente" name="utente" required>
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
<div class="modal fade" id="Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rimuovi utente</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <input type="hidden" value="" id="idUtenteDel" name="utente" required>
                <input type="hidden" name="fun" value="DEL">
                    <h4 id="h1-remove">

                    </h1>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-helper" type="button" data-dismiss="modal">Annulla</button>
                    <input class="btn btn-danger" type="submit" value="Elimina Utente"/>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Page Heading -->

<?php if($_SESSION['user']['RUOLO'] === "ADMIN"): ?> 

<div class="container mt-5">
<h1>Lista Utenti</h1>
<div id="tastiModificaElimina" style="display:none; " class="p-2"> 
 <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm p-2" data-toggle="modal" data-target="#Modify">Modifica Ruolo</a> 
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm p-2" data-toggle="modal" data-target="#Delete">Elimina utente</a>
</div>
</h1>
<div class="card-body">
    <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                <td><input class="text-center" type="radio" onclick="assegnaValore(this.value)" name="utente" value="<?= $utente['ID']."-".$utente['Nome']."-".$utente['Cognome']."-".$utente['CF']?>"/>
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
</div>
</div>
<?php endif?> 
<script>
    function assegnaValore(valore){
        document.getElementById('tastiModificaElimina').style.display = "block";
        let array = valore.split("-");
        document.getElementById('h1-remove').textContent="Vuoi eliminare l'utente " + array[1] + " " + array[2]
        + " " + array[3] + "?";
        document.getElementById('idUtente').value = array[0];
        document.getElementById('idUtenteDel').value = array[0];

    }
</script>
<?php else: Components::not_found(); endif; ?>