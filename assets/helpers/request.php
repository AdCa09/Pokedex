<?php

// Define a new 'url' function that takes a string parameter and returns the parsed URL
function url(string $request)
{
    // Use the 'parse_url' function to parse the provided URL and return the result
    return parse_url($request);
}

// Initialize an empty array to store the parsed query parameters
$result = [];

// Get the current request URL and parse it using the 'url' function
$url = url($_SERVER['REQUEST_URI']);

// Get the request method (e.g., GET, POST) from the server environment
$method = $_SERVER['REQUEST_METHOD'];


/* display pockemon */
function displayPokemon()
{
    global $dbh;

    $query = $dbh->prepare("SELECT * FROM pokemon");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    $query->closeCursor();
    return $result;  

}

function attacksCard($id)
{

    global $dbh;
    $query = $dbh->prepare("SELECT pokemonAttackLink.*, attack.* 
    FROM pokemonAttackLink 
    JOIN attack 
        ON pokemonAttackLink.id_attack = attack.id 
    WHERE pokemonAttackLink.id_pokemon = :id  
    LIMIT 2");

    $query->execute(['id' => intval($id)]);
    $attacks = $query->fetchAll(PDO::FETCH_ASSOC);

    $query->closeCursor();
    return $attacks;
}
