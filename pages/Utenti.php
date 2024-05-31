<?php
require_once('database.php');
if($_SESSION['user']['RUOLO'] === "ADMIN")
{
    $db = new Database();
    $utenti = $db->execute_query("SELECT RUOLI.DESCRIZIONE AS Ruolo, UTENTI.NOME AS Nome, UTENTI.COGNOME AS Cognome, UTENTI.EMAIL AS Email, UTENTI.CODICE_FISCALE AS CF, UTENTI.TELEFONO AS Telefono FROM UTENTI JOIN RUOLI ON UTENTI.ID_RUOLO = RUOLI.ID");
}
else{
    http_response_code(404);
        include('404.html');
        exit;
}
?> 
<?php if($_SESSION['user']['RUOLO'] === "ADMIN"): ?> 
<div class="container mt-5">
<h1>Lista Utenti</h1>
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
                <td><?php echo ($utente['Ruolo']); ?></td>
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
<?php endif;?> 
