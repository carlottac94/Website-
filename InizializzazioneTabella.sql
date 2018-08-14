-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 15 giu, 2011 at 12:18 
-- Versione MySQL: 5.5.8
-- Versione PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Utenti`
--

CREATE TABLE IF NOT EXISTS `Utenti_Consul` (
  `Email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Nome` varchar(200) NOT NULL,
  `Cognome` varchar(200) NOT NULL,
   `Durata_richiesta` decimal (3,0) NOT NULL,
   `Durata_assegnata` decimal (3,0) NOT NULL,
   `Inizio_assegnato` TIME NOT NULL,
   `Fine_assegnata` TIME NOT NULL,
  PRIMARY KEY (`Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


INSERT INTO `Utenti_Consul` (`Email`, `Password`,`Nome`,`Cognome`, `Durata_richiesta`,`Durata_assegnata`,`Inizio_assegnato`, `Fine_assegnata` ) VALUES
('a@p.it', md5('pO1'), 'Angelo', 'Bianchi', 0,0,'00:00:00','00:00:00'),
('b@p.it', md5('pO2'), 'Barbara', 'Rossi',0,0, '00:00:00', '00:00:00'),
('c@p.it', md5('pO3'), 'Claudio', 'Verde',0,0,'00:00:00','00:00:00');
