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


        $result = $pokemonEvo;

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

function register()
{
    global $dbh;

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirmation = $_POST["password_confirmation"];
    $errors = array();

    if (empty($username) || empty($email) || empty($password) || empty($passwordConfirmation)) {
        array_push($errors, "All fields are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }


    if ($password !== $passwordConfirmation) {
        array_push($errors, "Password does not match");
    }


    if (count($errors) == 0) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
        $stmt = $dbh->prepare($query);

        if ($stmt->execute([$username, $email, $hashedPassword])) {
            echo "<div>Registration successful!</div>";
        } else {
            array_push($errors, "An error occurred during registration");
        }
    }
    // Display errors if there are any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div>$error</div>";
        }
    }
}


function checkUser(string $name)
{
    global $dbh;

    try {
        $query = $dbh->prepare("SELECT name,role_id FROM user WHERE name= :name");
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