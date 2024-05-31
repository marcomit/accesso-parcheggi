<?php
    $profilo = (new Database())->execute_query("SELECT UTENTI.NOME AS Nome, UTENTI.COGNOME AS Cognome, UTENTI.EMAIL AS Email, UTENTI.CODICE_FISCALE AS CF, UTENTI.TELEFONO AS Telefono FROM UTENTI 
    WHERE UTENTI.ID = " . $_SESSION['user']['ID']);
?>
 <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Profilo</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                </div>
            <!--Profilo-->
            </div>
        <div id= class="">
            <p><? "Nome: ".$profilo['Nome'] ?></p>
            <br>
            <p><? "Cognome: ".$profilo['Cognome']?></p>
            <br>
            <p><? "Codice Fiscale: ".$profilo['CF']?></p>
            <br>
            <p><? "Numero di Telefono: ".$profilo['Telefono']?></p>
            <br>
            <p><? "Email: ".$profilo['Email'] ?></p>
            <br>
        </div>
    </div>
</div>
