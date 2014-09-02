-- phpMyAdmin SQL Dump
-- version 4.0.9deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 01 Août 2014 à 08:21
-- Version du serveur: 5.5.28-1
-- Version de PHP: 5.5.1-2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `netbilleterie`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonne`
--

CREATE TABLE IF NOT EXISTS `abonne` (
  `num_abonne` int(11) NOT NULL AUTO_INCREMENT,
  `num_client` int(11) NOT NULL,
  `abonne_jp` varchar(3) DEFAULT NULL COMMENT 'si abonne jeune public',
  `abonne_chanson` varchar(3) DEFAULT NULL COMMENT 'si abonne chanson',
  `type_abonne_jp` int(30) DEFAULT NULL,
  `type_abonne_chanson` int(30) DEFAULT NULL,
  `abonne_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date abonnement',
  PRIMARY KEY (`num_abonne`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE IF NOT EXISTS `abonnement` (
  `num_abonnement` int(11) NOT NULL AUTO_INCREMENT,
  `nom_abonnement` varchar(100) NOT NULL,
  `nombre_spectacle` int(11) NOT NULL,
  `tarif_abonnement` int(11) NOT NULL,
  `type_abonnement` varchar(50) NOT NULL,
  `saison` date DEFAULT NULL,
  `carnet` varchar(10) NOT NULL,
  `selection` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`num_abonnement`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `abonnement_comm`
--

CREATE TABLE IF NOT EXISTS `abonnement_comm` (
  `num_abo_com` int(30) NOT NULL AUTO_INCREMENT,
  `client_num` varchar(10) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `date_debut` date NOT NULL COMMENT 'date de debut d abonnement',
  `date_fin` date NOT NULL COMMENT 'date de fin d abonnement',
  `user` varchar(40) NOT NULL,
  `soir` varchar(200) NOT NULL,
  `tot_tva` float(20,2) NOT NULL DEFAULT '0.00',
  `attente` varchar(4) NOT NULL DEFAULT '0',
  `ctrl` varchar(4) NOT NULL DEFAULT 'non',
  `fact` varchar(4) NOT NULL DEFAULT 'non',
  `date_fact` date NOT NULL DEFAULT '0000-00-00',
  `paiement` varchar(20) NOT NULL DEFAULT 'non',
  `coment` varchar(200) NOT NULL,
  `num_abonnement` int(11) NOT NULL,
  `banque` int(40) NOT NULL,
  `titulaire_cheque` varchar(80) NOT NULL,
  `print` varchar(4) NOT NULL DEFAULT 'non',
  `nombre_place` int(11) NOT NULL,
  `num_spectacle_1` int(2) NOT NULL,
  `num_spectacle_2` int(2) NOT NULL,
  `num_spectacle_3` int(2) NOT NULL,
  `num_spectacle_4` int(2) NOT NULL,
  `num_spectacle_5` int(2) NOT NULL,
  `num_spectacle_6` int(2) NOT NULL,
  `num_spectacle_7` int(2) NOT NULL,
  PRIMARY KEY (`num_abo_com`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=619 ;

-- --------------------------------------------------------

--
-- Structure de la table `abonnement_paiement`
--

CREATE TABLE IF NOT EXISTS `abonnement_paiement` (
  `num_paiement` int(11) NOT NULL AUTO_INCREMENT,
  `num_abo_com` varchar(30) NOT NULL COMMENT 'id de la vente d abonnement dans abonnement_comm',
  `num_client` int(11) NOT NULL COMMENT 'numero du client dans client',
  `id_abonnement` int(11) NOT NULL COMMENT 'id de l abonnement (table abonnement)',
  `paiement` varchar(25) NOT NULL COMMENT 'moyen de paiement (id table type_paiement)',
  `total_ttc` int(11) NOT NULL COMMENT 'total paye par le client',
  `total_tva` int(11) NOT NULL COMMENT 'prix de la tva',
  `total_ht` int(11) NOT NULL COMMENT 'total hors taxe',
  `date_vente` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`num_paiement`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=163 ;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) NOT NULL,
  `designation` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `num` int(10) NOT NULL AUTO_INCREMENT,
  `image_article` varchar(250) NOT NULL,
  `article` varchar(40) NOT NULL DEFAULT '0',
  `type_article` varchar(100) NOT NULL,
  `annule` tinyint(1) NOT NULL DEFAULT '0',
  `numero_representation` int(11) NOT NULL DEFAULT '1',
  `lieu` varchar(40) NOT NULL,
  `horaire` varchar(10) NOT NULL,
  `date_spectacle` date NOT NULL DEFAULT '0000-00-00',
  `prix_htva` float NOT NULL DEFAULT '0',
  `taux_tva` float DEFAULT '0',
  `commentaire` varchar(255) NOT NULL DEFAULT '0',
  `uni` varchar(5) NOT NULL,
  `actif` varchar(5) NOT NULL,
  `stock` int(10) NOT NULL,
  `stomin` int(1) NOT NULL,
  `stomax` int(10) NOT NULL,
  `cat` varchar(10) NOT NULL,
  PRIMARY KEY (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Structure de la table `banque`
--

CREATE TABLE IF NOT EXISTS `banque` (
  `id_banque` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(256) NOT NULL,
  PRIMARY KEY (`id_banque`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Structure de la table `bon_comm`
--

CREATE TABLE IF NOT EXISTS `bon_comm` (
  `num_bon` int(30) NOT NULL AUTO_INCREMENT,
  `client_num` varchar(10) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `user` varchar(40) NOT NULL,
  `soir` varchar(200) NOT NULL,
  `tot_tva` float(20,2) NOT NULL DEFAULT '0.00',
  `attente` varchar(4) NOT NULL DEFAULT '0',
  `ctrl` varchar(4) NOT NULL DEFAULT 'non',
  `fact` varchar(4) NOT NULL DEFAULT 'non',
  `date_fact` date NOT NULL DEFAULT '0000-00-00',
  `paiement` varchar(20) NOT NULL DEFAULT 'non',
  `coment` varchar(200) NOT NULL,
  `id_tarif` int(11) NOT NULL,
  `banque` int(40) NOT NULL,
  `titulaire_cheque` varchar(80) NOT NULL,
  `print` varchar(4) NOT NULL DEFAULT 'non',
  `id_article` int(16) NOT NULL,
  PRIMARY KEY (`num_bon`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Structure de la table `caisse`
--

CREATE TABLE IF NOT EXISTS `caisse` (
  `id_caisse` int(10) NOT NULL AUTO_INCREMENT,
  `id_enregistrement_caisse` int(10) NOT NULL,
  `espece` decimal(5,2) NOT NULL,
  `nbr` int(10) NOT NULL,
  `total` decimal(5,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_caisse`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `num_client` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom2` varchar(30) NOT NULL,
  `rue` varchar(30) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `num_tva` varchar(30) NOT NULL,
  `login` varchar(10) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `actif` varchar(5) NOT NULL DEFAULT 'y',
  `permi` varchar(255) NOT NULL,
  `civ` varchar(15) NOT NULL,
  `tel` varchar(30) NOT NULL,
  `fax` varchar(30) NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`num_client`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=114 ;

-- --------------------------------------------------------

--
-- Structure de la table `client_liens`
--

CREATE TABLE IF NOT EXISTS `client_liens` (
  `num_client_parent` int(12) NOT NULL,
  `num_client_enfant` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cont_bon`
--

CREATE TABLE IF NOT EXISTS `cont_bon` (
  `num` int(30) NOT NULL AUTO_INCREMENT,
  `bon_num` varchar(30) NOT NULL,
  `print` varchar(4) NOT NULL DEFAULT 'non',
  `article_num` varchar(30) NOT NULL,
  `quanti` double NOT NULL DEFAULT '0',
  `prix_tarif` decimal(5,2) NOT NULL,
  `id_tarif` int(10) NOT NULL,
  `tot_art_htva` decimal(5,2) NOT NULL DEFAULT '0.00',
  `to_tva_art` decimal(20,2) NOT NULL DEFAULT '0.00',
  `p_u_jour` float(20,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

--
-- Structure de la table `enregistrement_caisse`
--

CREATE TABLE IF NOT EXISTS `enregistrement_caisse` (
  `id_enregistrement_caisse` int(10) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(10,2) NOT NULL,
  `commentaire` varchar(200) NOT NULL,
  `user` varchar(20) NOT NULL,
  `pointe` varchar(4) NOT NULL DEFAULT 'non',
  PRIMARY KEY (`id_enregistrement_caisse`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `num_groupe` int(12) NOT NULL AUTO_INCREMENT,
  `nom_structure` text CHARACTER SET utf8 NOT NULL,
  `adresse` longtext CHARACTER SET utf8 NOT NULL,
  `telephone` int(10) NOT NULL,
  PRIMARY KEY (`num_groupe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Structure de la table `mail`
--

CREATE TABLE IF NOT EXISTS `mail` (
  `id_mail` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `objet` varchar(150) NOT NULL,
  `message` mediumtext NOT NULL,
  `mail_client` longtext NOT NULL,
  `user_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id_mail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `session_data`
--

CREATE TABLE IF NOT EXISTS `session_data` (
  `session_id` varchar(32) NOT NULL DEFAULT '',
  `http_user_agent` varchar(32) NOT NULL DEFAULT '',
  `session_data` blob NOT NULL,
  `session_expire` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tarif`
--

CREATE TABLE IF NOT EXISTS `tarif` (
  `id_tarif` int(10) NOT NULL AUTO_INCREMENT,
  `nom_tarif` varchar(100) NOT NULL,
  `prix_tarif` decimal(5,2) NOT NULL,
  `saison` date DEFAULT NULL,
  `carnet` varchar(10) NOT NULL,
  `selection` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tarif`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Structure de la table `type_paiement`
--

CREATE TABLE IF NOT EXISTS `type_paiement` (
  `id_type_paiement` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nom` varchar(150) NOT NULL,
  PRIMARY KEY (`id_type_paiement`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `num` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `pwd` varchar(40) NOT NULL,
  `email` varchar(30) NOT NULL,
  `dev` char(1) NOT NULL DEFAULT 'n',
  `com` char(1) NOT NULL DEFAULT 'n',
  `fact` char(1) NOT NULL DEFAULT 'n',
  `admin` char(1) NOT NULL DEFAULT 'n',
  `dep` char(1) NOT NULL DEFAULT 'n',
  `stat` char(1) NOT NULL DEFAULT 'n',
  `art` char(1) NOT NULL DEFAULT 'n',
  `cli` char(1) NOT NULL DEFAULT 'n',
  `print_user` char(1) NOT NULL DEFAULT 'n',
  `menu` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`num`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
