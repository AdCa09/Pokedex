<?php

function index()
{
    // This could be placed in a folder called "models" - from here
    $nbrPokemon = count(displayPokemon(null));
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

    if ($checkLogin === 'true' || isset($_SESSION['user'])) {
        return header('Location: /');
        exit();
    } else {
        require_once __DIR__ . '/../views/pages/login.php';
    }

    return $checkLogin;
}

function registerUser()
{
    $registerUser = register($user);
    $form=''
    if (isset($_POST['submit']) || $registerUser === 'true') {

        return header('Location: /');

    } else {
        require_once __DIR__ . '/..views/pages/register.php';


    }
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

function logoutUser()
{

    $checkUnsetUser = logoutUnsetUser();


    if ($checkUnsetUser === 'true')
        return header('Location: /');
    else
        return 'logout fail!';
}
