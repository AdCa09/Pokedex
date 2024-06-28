<?php
// check si un user est connecter 
if (isset($_SESSION['user']))
    $roleUser = checkUser($_SESSION['user']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keyword" content="Pokemon,Pokeball,Pokedex">
    <meta name="description"
        content="A Pokédex is a portable electronic device that allows trainers to catalog and display information about the various Pokémon species they encounter.">
    <meta name="author" content="Adrien - Lyn - Ludovic">
    <meta name="robots" content="index, follow">
    <title><?php echo htmlspecialchars($title); ?> - Pokedex</title>
    <link href="../../assets/public/css/index.css" type="text/css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/assets/public/img/logo/pokeball.png">
</head>
<header>
    <img src="../../assets/public/img/logo/pokemon-logo.png" alt="Pokedex" srcset="">
</header>
<nav>
    <a href="/">Pokemon</a>
    <?php if (isset($_SESSION['user']) && $roleUser[0]['role_id'] === 1): ?>
        <a href="">my account</a>
    <?php endif; ?>
    <a href="">register</a>
    <?php if (!isset($_SESSION['user'])): ?>
        <a href="/login">login</a>
    <?php else: ?>
        <a href="/logout">logout</a>
    <?php endif; ?>
    <?php if (isset($_SESSION['user']) && $roleUser[0]['role_id'] === 2): ?>
        <a href="/dashboard">Admin</a>
    <?php endif; ?>
    <?php if ($title === 'Home') : ?>
    <form method="get" action="/">
        <?php 
        $value = (isset($_GET['search']) ? $_GET['search'] : '');
        ?>
        <input type="text" name="search" placeholder="ex:pikachu" value="<?= $value ?>" >       
        <input class="btn-search" type="submit" value="Search">
    </form>
    <?php endif; ?>
</nav>

<body>