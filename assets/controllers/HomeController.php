<?php

function index()
{
    // This could be placed in a folder called "models" - from here
<<<<<<< HEAD
    $user = [
        'name' => 'John Doe',
        'email' => 'johndoe@email.com'
    ];
    // to here -
=======

    $nbrPokemon =  count(displayPokemon(null));
    $limit = paginationRequest($nbrPokemon);

    //display Pokemon
    $viewPokemon = displayPokemon($limit);
>>>>>>> ludovic

    require_once __DIR__ . '/../views/pages/index.php';

    return $user;
}

function show($name)
{
    $viewPokemon = displayPokemonName($name);

    require_once __DIR__ . '/../views/pages/show.php';

    return $viewPokemon;
}
