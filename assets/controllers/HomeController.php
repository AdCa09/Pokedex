<?php

function index()
{
    // This could be placed in a folder called "models" - from here
    $nbrPokemon =  count(displayPokemon(null));
    $limit = paginationRequest($nbrPokemon);

    $search = isset($_GET['search']) ? $_GET['search'] : null;

    if ($search != null)
        $viewPokemon = displayPokemonName(securityInput($search));
    else
        $viewPokemon = displayPokemon($limit);

    require_once __DIR__ . '/../views/pages/index.php';

    return $viewPokemon;
}

function show($name)
{
    $viewPokemon = displayPokemonName($name);

    require_once __DIR__ . '/../views/pages/show.php';

    return $viewPokemon;
}

function loginUser()
{

    $checkLogin = login();

    if ($checkLogin === 'true' ||  isset($_SESSION['user'])) {
        return header('Location: /');
        exit();
    } else {
        require_once __DIR__ . '/../views/pages/login.php';
    }

    return $checkLogin;
}

function logoutUser()
{

    $checkUnsetUser = logoutUnsetUser();

    if ($checkUnsetUser === 'true')
        return header('Location: /');
    else
        return 'logout fail!';
}

function favoriAdd($user, $id)
{
    $checkLogin = login();
    $roleUser = checkUser($user);

    $page = isset($_SESSION['paginationIndex']) ? '?page=' . $_SESSION['paginationIndex'] : '';

    if ($roleUser[0]['role_id'] > 0) {
        $addFavoriPokemon = addFavori($roleUser[0]['id'], intval($id));
        return header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        return header('Location: /');
        exit();
    }
}
