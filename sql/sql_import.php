<?php

//connection parameters
$host = 'localhost';
$user = 'root';

//mysql connection
$mysqli = new mysqli($host, $user, "");
if ($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_errno);
    die();
}

//create database
if (!$mysqli->query('CREATE DATABASE db')) {
    printf("Error message: %s\n", $mysqli->error);
}

//create accounts table
$mysqli->query('
CREATE TABLE `db`.`accounts`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `index` VARCHAR(6) NULL,
    `role` VARCHAR(20) NOT NULL,
    `hash` VARCHAR(32) NOT NULL,
    `active` BOOLEAN NOT NULL DEFAULT 0,
PRIMARY KEY (`id`)
);') or die($mysqli->error);

//create questions table
$mysqli->query('
CREATE TABLE `db`.`questions`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `question` VARCHAR(500) NOT NULL,
    `answerA` VARCHAR(100) NOT NULL,
    `answerB` VARCHAR(100) NOT NULL,
    `answerC` VARCHAR(100) NOT NULL,
    `answerD` VARCHAR(100) NOT NULL,
    `right_answer` VARCHAR(1) NOT NULL,
    `author` INT NOT NULL,
    `category` VARCHAR(50) NOT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY (`author`) REFERENCES `accounts`(`id`)
);') or die($mysqli->error);

//create tests table
$mysqli->query('
CREATE TABLE `db`.`tests`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `info` VARCHAR(500) NULL,
PRIMARY KEY (`id`)
);') or die($mysqli->error);

//create test_question table - link between two tables
$mysqli->query('
CREATE TABLE `db`.`test_question`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `test_id` INT NOT NULL,
    `question_id` INT NOT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY (`test_id`) REFERENCES `tests`(`id`),
FOREIGN KEY (`question_id`) REFERENCES `questions`(`id`)
);') or die($mysqli->error);

//create results table
$mysqli->query('
CREATE TABLE `db`.`results`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `test_name` VARCHAR(100) NOT NULL,
    `user` INT NOT NULL,
    `percentage` VARCHAR(10) NOT NULL,
    `date_added` DATETIME NOT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY (`user`) REFERENCES `accounts`(`id`) 
);') or die($mysqli->error);

$mysqli->close();