<?php

# PHP-Fehler:
error_reporting(E_ALL);
ini_set('display_errors', '1');

# Beliebiger String  
$salt = 'lfGh§n4!5$89)7%&6HE5';

# Algorithmus:
$algo = 'sha1';

# DB-Daten
$server = 'localhost';
$user = 'root';
$password = 'toor';
$db = 'db_bibliography';
# Verbindung 
$mysqli = mysqli_connect($server, $user, $password, $db);

# radio-values
$radio_vals = ["b.german_title", "b.original_title", "concat(a.firstname,' ', a.lastname)", "p.name"];
