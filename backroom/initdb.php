<?php
require dirname(__FILE__)."/../dbman/includes/functions.php";
require dirname(__FILE__)."/../dbconf.php";
$dbc = new DbConn;

$dbc->conn->query("CREATE TABLE IF NOT EXISTS `$tbl_members` (
    `id` char(23) NOT NULL,
    `username` varchar(65) NOT NULL DEFAULT '',
    `password` varchar(65) NOT NULL DEFAULT '',
    `email` varchar(65) NOT NULL,
    `verified` tinyint(1) NOT NULL DEFAULT '0',
    `mod_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username_UNIQUE` (`username`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    UNIQUE KEY `email_UNIQUE` (`email`)
  )");
$dbc->conn->query("CREATE TABLE `$tbl_attempts` (
    `IP` varchar(20) NOT NULL,
    `Attempts` int(11) NOT NULL,
    `LastLogin` datetime NOT NULL,
    `Username` varchar(65) DEFAULT NULL,
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`ID`)
  )");
$dbc->conn->query("CREATE TABLE `$tbl_games` (
  `name` char(255) NOT NULL,
  `dir` char(255) NOT NULL,
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`gid`)
)");
$dbc->conn->query("CREATE TABLE `$tbl_saves` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(23),
  `gid` int(11),
  `save` varchar(255) NOT NULL,
  `lastgame` datetime NOT NULL,
  PRIMARY KEY (`sid`),
  CONSTRAINT `fk_SaveToUsr` FOREIGN KEY (`uid`) REFERENCES `members`(`id`),
  CONSTRAINT `fk_SaveToGame` FOREIGN KEY (`gid`) REFERENCES `game`(`gid`)
)");
$dbc->conn->query("CREATE TABLE `$tbl_scores` (
    `sid` int(11) NOT NULL AUTO_INCREMENT,
    `uid` char(23),
    `gid` int(11),
    `role` varchar(255) NOT NULL,
    `timestamp` varchar(255) NOT NULL,
    `score` varchar(255) NOT NULL,
    PRIMARY KEY (`sid`),
    CONSTRAINT `fk_ScoreToUsr` FOREIGN KEY (`uid`) REFERENCES `members`(`id`),
    CONSTRAINT `fk_ScoreToGame` FOREIGN KEY (`gid`) REFERENCES `game`(`gid`)
)");

echo "Database initialized";
