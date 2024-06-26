<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>

<body>
    <main>
        <?php
        if (isset($_POST["submit"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
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
                <input type="text" name="username" placeholder="pokemonlover8">
            </div>
            <div>
                <input type="email" name="email" placeholder="example@mail.com">
            </div>
            <div>
                <input type="date" name="birthday" placeholder="">
            </div>
            <div>
                <input type="password" name="password" placeholder="password">
            </div>
            <div>
                <input type="password" name="password_confirmation" placeholder="password confirmation">
            </div>
            <div>
                <input type="submit" value="New Account" name="submit">
            </div>

        </form>
    </main>
</body>

</html>