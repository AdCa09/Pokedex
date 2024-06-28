<?php
$adminName = $_SESSION['user'];

$pokemon = displayPokemon(null);
$id = (isset($_POST['id'])) ? $id : 0;

if ($id > 0 && $_POST['action'] === 'updatePokemon') {
    $action = '../../../dashbord/pokemon/update';
    $btnValue = 'Update';
    $pokemonUpdate = displayPokemonID($id, '*');
    $name = $pokemonUpdate[0]['name'];
    $num = $pokemonUpdate[0]['num'];
    $image = $pokemonUpdate[0]['image'];
    $description = $pokemonUpdate[0]['description'];
    $hp = $pokemonUpdate[0]['hp'];
    $attack = $pokemonUpdate[0]['attack'];
    $defense = $pokemonUpdate[0]['defense'];
    $specific_defense = $pokemonUpdate[0]['specific_defense'];
    $specific_attack = $pokemonUpdate[0]['specific_attack'];
    $speed = $pokemonUpdate[0]['speed'];
} else {
    $action = '../../../dashbord/pokemon/create';
    $btnValue = 'Create';
    $name = '';
    $num = '';
    $image = '';
    $description = '';
    $hp = '';
    $attack = '';
    $defense = '';
    $specific_defense = '';
    $specific_attack = '';
    $speed = '';
}

$title = "Dashboard";
require_once __DIR__ . '../../../partials/header.php';
echo '<h1>Hello, ' . htmlspecialchars($adminName);
'</h1>' ?>

<head>
    <link href="../../assets/public/css/dashboard.css" type="text/css" rel="stylesheet">
</head>
<h2>Admin Dashboard</h2>

<form id="create_form" method="post" action="<?= $action; ?>">
    <h4>Create New Pokemon</h4>
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value='<?= $name ?>' required><br>
    <label for="num">Num:</label><br>
    <input type="number" id="num" name="num" min='0' value='<?= $num ?>' required><br>
    <label for="image">Image URL:</label><br>
    <input type="text" id="image" name="image" value='<?= $image ?>' required><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required><?= $description ?></textarea><br>
    <label for="hp">HP:</label><br>
    <input type="number" id="hp" name="hp" value='<?= $hp; ?>' required><br>
    <label for="attack">Attack:</label><br>
    <input type="number" id="attack" name="attack" value='<?= $attack ?>' required><br>
    <label for="defense">Defense:</label><br>
    <input type="number" id="defense" name="defense" value='<?= $defense ?>' required><br>
    <label for="specific_defense">Specific Defense:</label><br>
    <input type="number" id="specific_defense" name="specific_defense" value='<?= $specific_defense ?>' required><br>
    <label for="specific_attack">Specific Attack:</label><br>
    <input type="number" id="specific_attack" name="specific_attack" value='<?= $specific_attack ?>' required><br>
    <label for="speed">Speed:</label><br>
    <input type="number" id="speed" name="speed" value='<?= $speed; ?>' required><br>
    <input type="hidden" name="action" value="<?= $btnValue; ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <input type="submit" value="<?= $btnValue; ?>">
</form>

<h4>Pokemon List</h4>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Num</th>
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
    <?php foreach ($pokemon as $row): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
<<<<<<< HEAD
            <td><img src="../../../assets/public/img/pokemon/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"
                    width="50"></td>
=======
            <td><?php echo $row['num']; ?></td>
            <td><img src="../../../assets/public/img/pokemon/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="50"></td>
>>>>>>> ludovic
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['hp']; ?></td>
            <td><?php echo $row['attack']; ?></td>
            <td><?php echo $row['defense']; ?></td>
            <td><?php echo $row['specific_defense']; ?></td>
            <td><?php echo $row['specific_attack']; ?></td>
            <td><?php echo $row['speed']; ?></td>
            <td>
                <form method="post" action="../../../dashbord/pokemon/update">
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
                    <input type="hidden" name="action" value="updatePokemon">
                    <input type="submit" value="Update">
                </form>
                <form method="post" action="../../../dashbord/pokemon/delete">
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

<?php
require_once __DIR__ . '../../../partials/footer.php';
?>