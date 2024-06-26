<?php
session_start();

include './assets/config/connexionDB.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = htmlspecialchars($_POST['login']);
    $password = $_POST['password'];

    try {
        $stmt = $dbh->prepare('SELECT * FROM user WHERE name = :login');
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $stmt_role = $dbh->prepare('SELECT role FROM role WHERE id = :role_id');
                $stmt_role->bindParam(':role_id', $user['role_id']);
                $stmt_role->execute();
                $role = $stmt_role->fetchColumn();

                if ($role == 2) { 
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: admin_board.php');
                    exit();
                } else {
                    $error = "You do not have admin rights.";
                }
            } else {
                $error = "Invalid login or password.";
            }
        } else {
            $error = "Invalid login or password.";
        }
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>
<body>
    <h2>Authentication Admin</h2>
    <form action="authentification_admin.php" method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <?php if (!empty($error)) : ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
</body>
</html>
