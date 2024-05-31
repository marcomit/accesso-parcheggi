GESTIONE ACCESSI
Descrizione dell’architettura
L’applicativo si basa sulla gestione degli accessi automatizzati e controllati al parcheggio interno dell’istituto.
In particolare:

Caratteristiche Utenti
È stata idealizzata una struttura relativa alla suddivisione degli utenti in Studenti, Personale Interno (docenti e personale ATA) e Esterni. Per ogni ruolo sono definite le direttive relative al permesso di accesso:
Studenti) i permessi dedicati agli studenti vengono emessi in casi eccezionali.
Personale Interno) I permessi vengono attivati recepiti e ed autorizzati senza criteri. Alla richiesta viene esplicitata la durata annuale.
Esterni) Vengono autorizzati permessi giornalieri su richiesta

Per elaborare le informazioni si è deciso di gestire i permessi con data di inizio e data di fine, senza specifica di orario.

Le autorizzazioni sono uniche per veicolo, ognuno dei tali legati ad un responsabile.


Database
Schema E/R database (proposto)

https://app.eraser.io/workspace/OHhKszQkfL0IDRpanIZ1?origin=share
Schema E/R realizzato in classe

https://lucid.app/lucidchart/f45c6f0d-4321-4588-8ef9-d74191b0a6e2/edit?viewport_loc=-697%2C-291%2C3012%2C1413%2C0_0&invitationId=inv_caf93ad6-8fbc-49e9-810b-0168200de62e
Implementazione su phpmyadmin
Applicazione
L’applicativo si compone di varie parti:
Componente web based per la base di dati e per il portale web Dashboard
Attrezzatura per il riconoscimento delle targhe veicolo
Gestione api con OpenCV 

Per l’accesso all’applicazione web non sono necessari terminali particolari, il portale è accessibile da qualunque dispositivo con connessione ad internet



Requisiti dashboard:

HOME

-Posti disponibili+tasto aggiorna

-Registro entrate ultimi 7 giorni+filtro per giorno da * a * 

-Registro uscite ultimi 7 giorni+filtro per giorno da * a *


TABS 

-Ricerca profilo per nome/targa->gestisci:

targhe auto(rimuovi o assegna una targa,se non registrata richiedi modello)
utente(es. operazioni profilo,aggiorna permessi per una o ogni auto,aggiorna classe(personale/docente o esterno))
cronologia registrazioni ultimi 30(?) giorni dell'utente

-richieste

rinnovo:nome,cognome permesso da rinnovare,durata (da * a *)e targa associata al permesso
targa:nome,cognome,targa ed eventuale permesso da aggiungere (da * a *)
registrazione:contenente ogni dato dell'utente(sempre aggiunti dallo stesso durante la registrazione),i quali:
	 dati anagrafici+classe(personale/docente o esterno)+targa(se nuova,allora viene richiesto il modello)
	 e tasto "aggiungi permesso(opzionale(?))"->durata(da * a*) 



LINK REPOSITORY
