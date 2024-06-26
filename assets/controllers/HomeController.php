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
