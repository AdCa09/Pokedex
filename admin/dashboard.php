<?php
session_start();


if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
$adminName = $_SESSION['admin'];

include '../assets/config/connexionDB.php';

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'create':
            $name = $_POST['name'];
            $image = $_POST['image'];
            $description = $_POST['description'];
            $hp = $_POST['hp'];
            $attack = $_POST['attack'];
            $defense = $_POST['defense'];
            $specific_defense = $_POST['specific_defense'];
            $specific_attack = $_POST['specific_attack'];
            $speed = $_POST['speed'];

            $stmt = $db->prepare("INSERT INTO pokemon (name, image, description, hp, attack, defense, specific_defense, specific_attack, speed) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $image, $description, $hp, $attack, $defense, $specific_defense, $specific_attack, $speed]);
            break;

        case 'update':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $image = $_POST['image'];
            $description = $_POST['description'];
            $hp = $_POST['hp'];
            $attack = $_POST['attack'];
            $defense = $_POST['defense'];
            $specific_defense = $_POST['specific_defense'];
            $specific_attack = $_POST['specific_attack'];
            $speed = $_POST['speed'];

            $stmt = $db->prepare("UPDATE pokemon SET name=?, image=?, description=?, hp=?, attack=?, defense=?, specific_defense=?, specific_attack=?, speed=? WHERE id=?");
            $stmt->execute([$name, $image, $description, $hp, $attack, $defense, $specific_defense, $specific_attack, $speed, $id]);
            break;

        case 'delete':
            $id = $_POST['id'];

            $stmt = $db->prepare("DELETE FROM pokemon WHERE id=?");
            $stmt->execute([$id]);
            break;
    }
}

$stmt = $db->query("SELECT * FROM pokemon");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
<header> <?php echo 'Bonjour, ' . htmlspecialchars($adminName); ?>
    <button onclick="location.href='logout.php';" class="logout-button">Logout</button>
</header>
    <h2>Admin Dashboard</h2>
    <h3>Manage Pokemon</h3>

    <form method="post" action="">
        <h4>Create New Pokemon</h4>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="image">Image URL:</label><br>
        <input type="text" id="image" name="image" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        <label for="hp">HP:</label><br>
        <input type="number" id="hp" name="hp" required><br>
        <label for="attack">Attack:</label><br>
        <input type="number" id="attack" name="attack" required><br>
        <label for="defense">Defense:</label><br>
        <input type="number" id="defense" name="defense" required><br>
        <label for="specific_defense">Specific Defense:</label><br>
        <input type="number" id="specific_defense" name="specific_defense" required><br>
        <label for="specific_attack">Specific Attack:</label><br>
        <input type="number" id="specific_attack" name="specific_attack" required><br>
        <label for="speed">Speed:</label><br>
        <input type="number" id="speed" name="speed" required><br>
        <input type="hidden" name="action" value="create">
        <input type="submit" value="Create">
    </form>

    <h4>Pokemon List</h4>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Description</th>
            <th>HP</th>
            <th>Attack</th>
            <th>Defense</th>
            <th>Specific Defense</th>
            <th>Specific Attack</th>
            <th>Speed</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="50"></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['hp']; ?></td>
                <td><?php echo $row['attack']; ?></td>
                <td><?php echo $row['defense']; ?></td>
                <td><?php echo $row['specific_defense']; ?></td>
                <td><?php echo $row['specific_attack']; ?></td>
                <td><?php echo $row['speed']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                        <input type="hidden" name="image" value="<?php echo $row['image']; ?>">
                        <input type="hidden" name="description" value="<?php echo $row['description']; ?>">
                        <input type="hidden" name="hp" value="<?php echo $row['hp']; ?>">
                        <input type="hidden" name="attack" value="<?php echo $row['attack']; ?>">
                        <input type="hidden" name="defense" value="<?php echo $row['defense']; ?>">
                        <input type="hidden" name="specific_defense" value="<?php echo $row['specific_defense']; ?>">
                        <input type="hidden" name="specific_attack" value="<?php echo $row['specific_attack']; ?>">
                        <input type="hidden" name="speed" value="<?php echo $row['speed']; ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="submit" value="Update">
                    </form>
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        echo "<h4>Update Pokemon</h4>";
        echo "<form method='post' action=''>";
        echo "<label for='name'>Name:</label><br>";
        echo "<input type='text' id='name' name='name' value='" . $_POST['name'] . "' required><br>";
        echo "<label for='image'>Image URL:</label><br>";
        echo "<input type='text' id='image' name='image' value='" . $_POST['image'] . "' required><br>";
        echo "<label for='description'>Description:</label><br>";
        echo "<textarea id='description' name='description' required>" . $_POST['description'] . "</textarea><br>";
        echo "<label for='hp'>HP:</label><br>";
        echo "<input type='number' id='hp' name='hp' value='" . $_POST['hp'] . "' required><br>";
        echo "<label for='attack'>Attack:</label><br>";
        echo "<input type='number' id='attack' name='attack' value='" . $_POST['attack'] . "' required><br>";
        echo "<label for='defense'>Defense:</label><br>";
        echo "<input type='number' id='defense' name='defense' value='" . $_POST['defense'] . "' required><br>";
        echo "<label for='specific_defense'>Specific Defense:</label><br>";
        echo "<input type='number' id='specific_defense' name='specific_defense' value='" . $_POST['specific_defense'] . "' required><br>";
        echo "<label for='specific_attack'>Specific Attack:</label><br>";
        echo "<input type='number' id='specific_attack' name='specific_attack' value='" . $_POST['specific_attack'] . "' required><br>";
        echo "<label for='speed'>Speed:</label><br>";
        echo "<input type='number' id='speed' name='speed' value='" . $_POST['speed'] . "' required><br>";
        echo "<input type='hidden' name='id' value='" . $_POST['id'] . "'>";
        echo "<input type='hidden' name='action' value='update'>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
    }


    ?>

</body>

</html>