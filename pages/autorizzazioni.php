<?php

$current_user = $_SESSION['user'];

if($current_user["RUOLO"] !== "ADMIN"){
  echo "Non hai i permessi per accedere a questa pagina";
}
else{
  echo "Sei solo uno studente";
}
?>