<?php

function index()
{
    // This could be placed in a folder called "models" - from here
    $nbrPokemon =  count(displayPokemon(null));
    $limit = paginationRequest($nbrPokemon);

    //display Pokemon
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

function dashboardAdmin($user)
{


    $checkLogin = login();
    $roleUser = checkUser($user);

    if ($roleUser[0]['role_id'] === 2) {
        require_once __DIR__ . '/../views/pages/admin/dashboard.php';
        return $checkLogin;
    } else {
        return header('Location: /');
        exit();
    }
}

function pokemonCreate($user)
{

    $checkLogin = login();
    $roleUser = checkUser($user);

    if ($roleUser[0]['role_id'] === 2) {

        if (isset($_POST['action']) && $_POST['action'] === 'Create')
            $create = createPokemon($_POST);

        return header('Location: /dashboard');
        exit();
    } else {
        return header('Location: /');
        exit();
    }
}

function pokemonUpdate($user, $id)
{

    $checkLogin = login();
    $roleUser = checkUser($user);

    if ($roleUser[0]['role_id'] === 2) {

        if (isset($_POST['action']) && $_POST['action'] === 'Update') {
            $update = updatePokemon($_POST);
            return header('Location: /dashboard');
            exit();
        }

        require_once __DIR__ . '/../views/pages/admin/dashboard.php';
        return $_POST;
    } else {
        return header('Location: /');
        exit();
    }
}
function pokemonDelete($user, $id)
{

    $checkLogin = login();
    $roleUser = checkUser($user);

    if ($roleUser[0]['role_id'] === 2) {

        if (isset($_POST['action']) && $_POST['action'] === 'delete') {
            $delete = deletePokemon($id);
            return header('Location: /dashboard');
            exit();
        }
        require_once __DIR__ . '/../views/pages/admin/dashboard.php';
    } else {
        return header('Location: /');
        exit();
    }
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

    if ($roleUser[0]['role_id'] > 0) {
        $addFavoriPokemon = addFavori($roleUser[0]['id'],intval($id));
        return header('Location: /');
        exit();
    } else {
        return header('Location: /');
        exit();
    }
}
