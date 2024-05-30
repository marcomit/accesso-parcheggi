-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Mag 27, 2024 alle 16:10
-- Versione del server: 5.7.39
-- Versione PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `info5bia_targhe`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `ACCESSI_UTENTE`
--

CREATE TABLE `ACCESSI_UTENTE` (
  `ID` int(11) NOT NULL,
  `DATA` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ID_UTENTE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `ACCESSI_UTENTE`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `ACCESSI_VEICOLO`
--

CREATE TABLE `ACCESSI_VEICOLO` (
  `ID` int(11) NOT NULL,
  `ENTRATA` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `USCITA` datetime DEFAULT NULL,
  `ID_VEICOLO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `AUTORIZZAZIONI`
--

CREATE TABLE `AUTORIZZAZIONI` (
  `ID` int(11) NOT NULL,
  `INIZIO` datetime NOT NULL,
  `FINE` datetime NOT NULL,
  `ID_VEICOLO` int(11) NOT NULL,
  `STATO_RICHIESTA` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `RUOLI`
--

CREATE TABLE `RUOLI` (
  `ID` int(11) NOT NULL,
  `DESCRIZIONE` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `RUOLI`
--

INSERT INTO `RUOLI` (`ID`, `DESCRIZIONE`) VALUES
(1, 'STUDENTE'),
(2, 'DOCENTE'),
(3, 'PERSONALE'),
(4, 'ALTRO'),
(5, 'ADMIN');

-- --------------------------------------------------------

--
-- Struttura della tabella `TIPI_VEICOLO`
--

CREATE TABLE `TIPI_VEICOLO` (
  `ID` int(11) NOT NULL,
  `DESCRIZIONE` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `UTENTI`
--

CREATE TABLE `UTENTI` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(256) NOT NULL,
  `COGNOME` varchar(256) NOT NULL,
  `TELEFONO` varchar(256) NOT NULL,
  `CODICE_FISCALE` varchar(16) NOT NULL,
  `EMAIL` varchar(256) NOT NULL,
  `PASSWORD` varchar(256) NOT NULL,
  `ID_RUOLO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `UTENTI`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `VEICOLI`
--

CREATE TABLE `VEICOLI` (
  `ID` int(11) NOT NULL,
  `TARGA` varchar(7) NOT NULL,
  `MODELLO` varchar(256) NOT NULL,
  `ID_TIPO` int(11) NOT NULL,
  `ID_UTENTE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ACCESSI_UTENTE`
--
ALTER TABLE `ACCESSI_UTENTE`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ACCESSO_UTENTE` (`ID_UTENTE`);

--
-- Indici per le tabelle `ACCESSI_VEICOLO`
--
ALTER TABLE `ACCESSI_VEICOLO`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ACCESSO_VEICOLO` (`ID_VEICOLO`);

--
-- Indici per le tabelle `AUTORIZZAZIONI`
--
ALTER TABLE `AUTORIZZAZIONI`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_AUTORIZZAZIONE_VEICOLO` (`ID_VEICOLO`),
  ADD KEY `FK_AUTORIZZAZIONE_RICHIESTA` (`STATO_RICHIESTA`);

--
-- Indici per le tabelle `RUOLI`
--
ALTER TABLE `RUOLI`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `TIPI_VEICOLO`
--
ALTER TABLE `TIPI_VEICOLO`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `UTENTI`
--
ALTER TABLE `UTENTI`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_RUOLO_UTENTE` (`ID_RUOLO`);

--
-- Indici per le tabelle `VEICOLI`
--
ALTER TABLE `VEICOLI`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_VEICOLO_UTENTE` (`ID_UTENTE`),
  ADD KEY `FK_VEICOLO_TIPO` (`ID_TIPO`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `ACCESSI_UTENTE`
--
ALTER TABLE `ACCESSI_UTENTE`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `ACCESSI_VEICOLO`
--
ALTER TABLE `ACCESSI_VEICOLO`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `AUTORIZZAZIONI`
--
ALTER TABLE `AUTORIZZAZIONI`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `RUOLI`
--
ALTER TABLE `RUOLI`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `TIPI_VEICOLO`
--
ALTER TABLE `TIPI_VEICOLO`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `UTENTI`
--
ALTER TABLE `UTENTI`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `VEICOLI`
--
ALTER TABLE `VEICOLI`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ACCESSI_UTENTE`
--
ALTER TABLE `ACCESSI_UTENTE`
  ADD CONSTRAINT `FK_ACCESSO_UTENTE` FOREIGN KEY (`ID_UTENTE`) REFERENCES `UTENTI` (`ID`);

--
-- Limiti per la tabella `ACCESSI_VEICOLO`
--
ALTER TABLE `ACCESSI_VEICOLO`
  ADD CONSTRAINT `FK_ACCESSO_VEICOLO` FOREIGN KEY (`ID_VEICOLO`) REFERENCES `VEICOLI` (`ID`);

--
-- Limiti per la tabella `AUTORIZZAZIONI`
--
ALTER TABLE `AUTORIZZAZIONI`
  ADD CONSTRAINT `FK_AUTORIZZAZIONE_VEICOLO` FOREIGN KEY (`ID_VEICOLO`) REFERENCES `VEICOLI` (`ID`);

--
-- Limiti per la tabella `UTENTI`
--
ALTER TABLE `UTENTI`
  ADD CONSTRAINT `FK_RUOLO_UTENTE` FOREIGN KEY (`ID_RUOLO`) REFERENCES `RUOLI` (`ID`);

--
-- Limiti per la tabella `VEICOLI`
--
ALTER TABLE `VEICOLI`
  ADD CONSTRAINT `FK_VEICOLO_TIPO` FOREIGN KEY (`ID_TIPO`) REFERENCES `TIPI_VEICOLO` (`ID`),
  ADD CONSTRAINT `FK_VEICOLO_UTENTE` FOREIGN KEY (`ID_UTENTE`) REFERENCES `UTENTI` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
