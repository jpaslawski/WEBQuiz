<?php

//Database connection settings
$host = 'localhost';
$user = 'root';
$db = 'db';

$mysqli = new mysqli($host, $user, "", $db) or die($mysqli->error);