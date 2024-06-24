<?php

$user = 'myuser'; // Remplacer par l'input du login
$psw = 'mypassword';
$host = 'mysql';
$dbname = 'pokedex'; 

try {
    
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $psw); 
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    echo 'Connexion impossible : ' . $e->getMessage();
}
