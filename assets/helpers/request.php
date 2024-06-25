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
function displayPokemon($limit)
{
    global $dbh;

    try {

        if ($limit != null) {

            $limit = intval($limit);

            $query = $dbh->prepare("SELECT * FROM pokemon LIMIT :limitNbr");
            $query->bindParam(':limitNbr', $limit, PDO::PARAM_INT);
            $query->execute();
        } else {
            $query = $dbh->prepare("SELECT * FROM pokemon");
            $query->execute();
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $result;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}

/* display pockemon */
function displayPokemonName(string $name)
{
    global $dbh;
    try {

        $query = $dbh->prepare("SELECT * FROM pokemon WHERE name= :namePokemon");
        $query->execute(['namePokemon' => $name]);
        $pokemon = $query->fetchAll(PDO::FETCH_ASSOC);

        $query->closeCursor();
        return $pokemon;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}

/* display pockemon */
function displayPokemonID(int $id, string $champs)
{
    global $dbh;
    try {

        $query = $dbh->prepare("SELECT " . $champs . " FROM pokemon WHERE id= :id");
        $query->execute(['id' => $id]);
        $pokemon = $query->fetchAll(PDO::FETCH_ASSOC);

        $query->closeCursor();
        return $pokemon;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}

function attacksCard(int $id)
{

    global $dbh;
    try {

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
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
function attacks(int $id)
{

    global $dbh;
    try {

        $query = $dbh->prepare("SELECT pokemonAttackLink.*, attack.* 
        FROM pokemonAttackLink 
        JOIN attack 
            ON pokemonAttackLink.id_attack = attack.id 
        WHERE pokemonAttackLink.id_pokemon = :id");

        $query->execute(['id' => intval($id)]);
        $attacks = $query->fetchAll(PDO::FETCH_ASSOC);

        $query->closeCursor();
        return $attacks;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
function evolution(int $id)
{

    global $dbh;
    try {
        $id = intval($id);

        $query = $dbh->prepare("SELECT * FROM evolutionLink WHERE id_pokemon_evolved = :id");
        $query->execute(['id' => $id]);
        $evolution = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();


        if (!$evolution) {

            $queryEvolution = $dbh->prepare("SELECT id_pokemon_evolved,id_pokemon_initial
                                             FROM evolutionLink 
                                             WHERE id_pokemon_initial = :id
                                             ORDER BY `order_evolution` ASC");
            $queryEvolution->execute(['id' => $id]);
            $pokemonEvo = $queryEvolution->fetchAll(PDO::FETCH_ASSOC);
            $queryEvolution->closeCursor();
        } else {

            $pokemonEvoInit["id_pokemon_evolved"] = $evolution['id_pokemon_initial'];

            $queryEvolution = $dbh->prepare("SELECT id_pokemon_evolved,id_pokemon_initial
                                             FROM evolutionLink 
                                             WHERE id_pokemon_initial = :id
                                             ORDER BY `order_evolution` ASC");
            $queryEvolution->execute(['id' => $evolution['id_pokemon_initial']]);
            $pokemonEvo = $queryEvolution->fetchAll(PDO::FETCH_ASSOC);
            $queryEvolution->closeCursor();
        }


        $result =  $pokemonEvo;

        return $result;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage(); // Gestion de l'exception PDO
    }
}


function paginationRequest(int $number)
{

    $nbrPokemon = $number; // nombre de record dans la db
    $nbrItem = 3; // nombre de record afficher 
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // check si le param page existe
    $nbrPage = ceil($nbrPokemon / $nbrItem); // calcule le nombre de page en fonction de $nbrPokemon  &  $page et arround sup


    $limit = (intval($page) < intval($nbrPage)) ? $page * $nbrItem : $nbrPokemon;
    $_SESSION['pageIndex'] = $nbrPage;

    return $limit;
}

function pagination()
{

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $_SESSION['paginationIndex'] = $page;

    $page += 1;

    return $page;
}
