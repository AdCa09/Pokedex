<?php
session_start();

require '../assets/config/connexionDB.php';

if (isset($_POST['valider'])) {
    $pseudo_input = htmlspecialchars($_POST['name']);
    $psw_input = htmlspecialchars($_POST['password']);

    $query = "SELECT id, name, password FROM user WHERE name = ? AND password = ? AND role_id = 2";
    $stmt = $db->prepare($query);
    $stmt->execute([$pseudo_input, sha1($psw_input)]); 

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['admin'] = $user['name'];
        echo
        header('Location: dashboard.php'); 
        exit(); 
    } else {
        echo 'Nom d\'utilisateur ou mot de passe incorrect';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="">
        <label for="name">Username:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="valider" value="Login">
    </form>
    <?php
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>
</body>
</html>
