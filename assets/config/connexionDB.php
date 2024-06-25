<?php
$serveur = 'localhost';
$nomUtilisateur = 'root';
$motDePasse = '';
$nomBase = 'pokedex';

try {
    $db = new PDO("mysql:host=$serveur;dbname=$nomBase", $nomUtilisateur, $motDePasse);
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connexion réussie à la base de données.";
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
