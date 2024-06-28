<?php
session_start();
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

// nombre de record afficher 
$nbrItem = 4;


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

        $query = $dbh->prepare("SELECT * FROM pokemon WHERE name  LIKE :namePokemon");
        $query->execute(['namePokemon' => $name .'%']);
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

        $query = $dbh->prepare("SELECT pokemonattacklink.*, attack.* 
        FROM pokemonattacklink 
        JOIN attack 
            ON pokemonattacklink.id_attack = attack.id 
        WHERE pokemonattacklink.id_pokemon = :id  
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

        $query = $dbh->prepare("SELECT pokemonattacklink.*, attack.* 
        FROM pokemonattacklink 
        JOIN attack 
            ON pokemonattacklink.id_attack = attack.id 
        WHERE pokemonattacklink.id_pokemon = :id");

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

        $query = $dbh->prepare("SELECT * FROM evolutionlink WHERE id_pokemon_evolved = :id");
        $query->execute(['id' => $id]);
        $evolution = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();


        if (!$evolution) {

            $queryEvolution = $dbh->prepare("SELECT id_pokemon_evolved,id_pokemon_initial
                                             FROM evolutionlink 
                                             WHERE id_pokemon_initial = :id
                                             ORDER BY `order_evolution` ASC");
            $queryEvolution->execute(['id' => $id]);
            $pokemonEvo = $queryEvolution->fetchAll(PDO::FETCH_ASSOC);
            $queryEvolution->closeCursor();
        } else {

            $pokemonEvoInit["id_pokemon_evolved"] = $evolution['id_pokemon_initial'];

            $queryEvolution = $dbh->prepare("SELECT id_pokemon_evolved,id_pokemon_initial
                                             FROM evolutionlink 
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
    global $nbrItem;
    $nbrPokemon = $number; // nombre de record dans la db
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

function login()
{

    global $dbh;

    if (isset($_POST['valider'])) {
        $pseudo_input = htmlspecialchars($_POST['name']);
        $psw_input = htmlspecialchars($_POST['password']);

        $query = "SELECT id, name, password FROM user WHERE name = ? AND password = ? ";
        $stmt = $dbh->prepare($query);
        $stmt->execute([$pseudo_input, sha1($psw_input)]);


        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if ($user) {
            $_SESSION['user'] = $user['name'];
            return 'true';
        } else {
            return 'false';
        }
    }
}

function checkUser(string $name)
{
    global $dbh;

    try {
        $query = $dbh->prepare("SELECT id,name,role_id FROM user WHERE name= :name");
        $query->execute(['name' => $name]);
        $user = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($user)
            return $user;
        else
            return 0;

        $query->closeCursor();
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage(); // Gestion de l'exception PDO
    }
}

function logoutUnsetUser()
{

    unset($_SESSION['user']);

    if (!isset($_SESSION['user']))
        return 'true';
    else
        return 'false';
}

function createPokemon($postPokemon)
{

    global $dbh;

    $name = securityInput($postPokemon['name']);
    $num = securityInput($postPokemon['num']);
    $image = securityInput($postPokemon['image']);
    $description = securityInput($postPokemon['description']);
    $hp = securityInput($postPokemon['hp']);
    $attack = securityInput($postPokemon['attack']);
    $defense = securityInput($postPokemon['defense']);
    $specific_defense = securityInput($postPokemon['specific_defense']);
    $specific_attack = securityInput($postPokemon['specific_attack']);
    $speed = securityInput($postPokemon['speed']);

    $stmt = $dbh->prepare("INSERT INTO pokemon (name,num, image, description, hp, attack, defense, specific_defense, specific_attack, speed) 
                                          VALUES (?,?,?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $num, $image, $description, $hp, $attack, $defense, $specific_defense, $specific_attack, $speed]);

    $_SESSION['favori']['status'] =  'success';
    $_SESSION['favori']['msg'] =  'Pokemon' . $name . ' was created';
}

function updatePokemon($postPokemon)
{

    global $dbh;

    $id = $_POST['id'];
    $name = securityInput($postPokemon['name']);
    $num = securityInput($postPokemon['num']);
    $image = securityInput($postPokemon['image']);
    $description = securityInput($postPokemon['description']);
    $hp = securityInput($postPokemon['hp']);
    $attack = securityInput($postPokemon['attack']);
    $defense = securityInput($postPokemon['defense']);
    $specific_defense = securityInput($postPokemon['specific_defense']);
    $specific_attack = securityInput($postPokemon['specific_attack']);
    $speed = securityInput($postPokemon['speed']);

    $stmt = $dbh->prepare("UPDATE pokemon SET name=?, num=?, image=?, description=?, hp=?, attack=?, defense=?, specific_defense=?, specific_attack=?, speed=? WHERE id=?");
    $stmt->execute([$name, $num, $image, $description, $hp, $attack, $defense, $specific_defense, $specific_attack, $speed, $id]);

    $_SESSION['favori']['status'] =  'success';
    $_SESSION['favori']['msg'] =  'Pokemon ' . $name . ' has been changed';
}

function deletePokemon($id)
{
    global $dbh;

    $stmt = $dbh->prepare("DELETE FROM pokemon WHERE id=?");
    $stmt->execute([$id]);

    $_SESSION['favori']['status'] =  'delete';
    $_SESSION['favori']['msg'] =  'Pokemon was removed.';

    deleteFavoriAll($id);
}

function favori($user_id, $id_pokemon)
{
    global $dbh;
    $query = $dbh->prepare("SELECT COUNT(*) FROM favori WHERE id_user = :user_id AND id_pokemon = :pokemon_id");
    $query->execute(['user_id' => intval($user_id), 'pokemon_id' => intval($id_pokemon)]);
    $count = $query->fetchColumn();

    $query->closeCursor();
    return $count;
}

function addFavori($user_id, $id_pokemon)
{

    global $dbh;

    $count = favori($user_id, $id_pokemon);

    if ($count == 0) {

        $query = $dbh->prepare("INSERT INTO favori(id_user, id_pokemon) VALUES (:user_id, :pokemon_id)");
        $query->execute(['user_id' => intval($user_id), 'pokemon_id' => intval($id_pokemon)]);

        $_SESSION['favori']['status'] =  'success';
        $_SESSION['favori']['msg'] =  'Pokemon add to favorite.';
    } else {
        deleteFavori($user_id, $id_pokemon);
        $_SESSION['favori']['status']  =  'delete';
        $_SESSION['favori']['msg'] =  'Pokemon delete to favorite.';
    }
}

function deleteFavori($user_id, $id_pokemon)
{

    global $dbh;

    $query = $dbh->prepare("DELETE FROM favori WHERE id_user = :user_id AND id_pokemon = :pokemon_id");
    $query->execute(['user_id' => intval($user_id), 'pokemon_id' => intval($id_pokemon)]);
}

function deleteFavoriAll($id_pokemon)
{

    global $dbh;

    $query = $dbh->prepare("DELETE FROM favori WHERE id_pokemon = :pokemon_id");
    $query->execute(['pokemon_id' => intval($id_pokemon)]);
}

function securityInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
