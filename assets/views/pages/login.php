<?php
$title = "Login";
require_once __DIR__ . '../../partials/header.php';

?>
    <h2>Login</h2>
    <form method="post" action="../login">
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
<?php
require_once __DIR__ . '../../partials/footer.php';
?>
