<?php
session_start();
include '../assets/config/connexionDB.php';

if (!isset($_SESSION['password'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    $fetchUser = $db->query('SELECT * FROM user');
    while($user = $fetchUser->fetch()){
        ?>
        <p><?= $user['name']; ?></p>
        <?php
    }

?>

</body>
</html>