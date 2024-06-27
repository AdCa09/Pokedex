<?php 
// check si un user est connecter 
if(isset($_SESSION ['user']))
    $roleUser = checkUser($_SESSION ['user']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> - Pokedex</title>
    <link href="../../assets/public/css/styles.css" type="text/css" rel="stylesheet">
</head>
<header>
    <img src="../../assets/public/img/logo/pokemon-logo.png" alt="Pokedex" srcset="">
</header>
<nav>
    <a href="/">Pokemon</a>
    <?php if(isset($_SESSION['user']) && $roleUser[0]['role_id'] === 1 ): ?>
    <a href="">my account</a>
    <?php endif; ?>
    <a href="">register</a>
    <?php if(!isset($_SESSION['user']) ): ?>
    <a href="/login">login</a>
    <?php else : ?>
    <a href="/logout">logout</a>
    <?php endif; ?>
    <?php if(isset($_SESSION['user']) && $roleUser[0]['role_id'] === 2 ): ?>
    <a href="/dashboard">Admin</a>
    <?php endif; ?>
</nav>
<body>