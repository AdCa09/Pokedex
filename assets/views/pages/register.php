<?php 
require_once __DIR__ . '../../partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="/assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <main>
        <?php
        include ("config.php");
        if (isset($_POST["submit"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $passwordConfirmation = $_POST["password_confirmation"];
            $errors = array();
            if (empty($username) or empty($email) or empty($password) or empty($passwordConfirmation))
                (array_push($errors, "All fields are required"));
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }


        if ($password !== $passwordConfirmation) {
            array_push($errors, "Password does not match");
        }

        if (count($errors) > 0) {
            foreach ($errors as $error)
                echo ("<div>$error</div>");

        }
        ?>
        <form action="register.php" method="post">
            <div>
                <h2> register</h2>

                <label>
                    <input type="text" name="username" placeholder="pokemonlover8">
                </label>
            </div>

            <div>
                <label>
                    <input  type="email" name="email" placeholder="example@mail.com"></label>

            </div>
            <div>
                <label>
                    <input  type="date" name="birthday" max="2011-12-31" placeholder="">
                </label>

            </div>
            <div>
                <label>
                    <input type="password" name="password" placeholder="password">
                </label>

            </div>
            <div>
                <label>
                    <input type="password" name="password_confirmation" placeholder="password confirmation">
                </label>

            </div>

            <div>
                <label>
                    <input class="submit" type="submit" value="New Account" name="submit">
                </label>

            </div>

        </form>
    </main>
</body>

<?php
require_once __DIR__ . '../../partials/footer.php';
?>