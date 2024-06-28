<?php
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
function evolutionAdmin($user){

    $checkLogin = login();
    $roleUser = checkUser($user);

    if ($roleUser[0]['role_id'] === 2) {
        require_once __DIR__ . '/../views/pages/admin/evolutions.php';
        return $checkLogin;
    } else {
        return header('Location: /');
        exit();
    }
}
