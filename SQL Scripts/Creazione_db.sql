DROP DATABASE IF EXISTS chronolet;
CREATE DATABASE chronolet;
USE chronolet;

-- Tabella utenti
DROP TABLE IF EXISTS utente;
CREATE TABLE utente(
	username VARCHAR(100) NOT NULL PRIMARY KEY,
    `password` VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Tabella circuiti
DROP TABLE IF EXISTS circuito;
CREATE TABLE circuito(
	nome VARCHAR(100) NOT NULL,
    localita VARCHAR(255) NOT NULL,
    lunghezza FLOAT NOT NULL,
    PRIMARY KEY(nome)
)ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Tabella tempi
DROP TABLE IF EXISTS tempo;
CREATE TABLE tempo(
	id_tempo INTEGER AUTO_INCREMENT NOT NULL,
	pilota VARCHAR(100) NOT NULL REFERENCES utente(username),
    moto VARCHAR(100) NOT NULL REFERENCES archiviomoto(modello),
    circuito VARCHAR(100) NOT NULL REFERENCES circuito(nome),
    `data` DATE NOT NULL,
    t_lap INTEGER NOT NULL,
    t_s1 INTEGER NOT NULL, -- settore 1
    t_s2 INTEGER NOT NULL, -- settore 2
    t_s3 INTEGER NOT NULL, -- settore 3
    t_s4 INTEGER NOT NULL, -- settore 4
    PRIMARY KEY(id_tempo)
)ENGINE=INNODB DEFAULT CHARSET=LATIN1;

-- Tabella Moto Conosciute
DROP TABLE IF EXISTS archiviomoto;
CREATE TABLE archiviomoto(
	marca VARCHAR(100) NOT NULL,
    modello VARCHAR(100) NOT NULL,
    cilindrata INT NOT NULL,
    PRIMARY KEY(marca, modello)
)ENGINE=INNODB DEFAULT CHARSET=LATIN1;