<?php


function index()
{
    // This could be placed in a folder called "models" - from here

    //display Pokemon
    $viewPokemon = displayPokemon();

    require_once __DIR__ . '/../views/pages/index.php';

    return $viewPokemon;
}

function show()
{
    require_once __DIR__ . '/../views/pages/show.php';
}
?>