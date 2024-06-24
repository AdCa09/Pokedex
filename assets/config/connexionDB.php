<?php

$user = 'adri'; // Remplacer par l'input du login
$psw = 'adri';
$host = 'localhost';
$dbname = 'pokedex'; 

try {
    
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $psw); 
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion établie';
    
} catch (PDOException $e) {
    echo 'Connexion impossible : ' . $e->getMessage();
}
