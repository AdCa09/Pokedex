<?php

$user = 'myuser'; // Remplacer par l'input du login
$psw = 'mypassword';
$host = 'mysql';
$dbname = 'pokedex'; 

try {
    
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $psw); 
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
<<<<<<< HEAD
    echo 'Connexion établie';
    
} catch (PDOException $e) {
=======
    } catch (PDOException $e) {
>>>>>>> ludovic
    echo 'Connexion impossible : ' . $e->getMessage();
}
