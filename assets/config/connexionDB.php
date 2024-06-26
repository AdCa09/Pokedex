<?php
$serveur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = '';
$nomBase = 'pokedex';

try {
    $db = new PDO("mysql:host=$serveur;dbname=$nomBase", $nomUtilisateur, $motDePasse);
    
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $psw); 
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connexion établie';
    
} catch (PDOException $e) {
    echo 'Connexion impossible : ' . $e->getMessage();
}
