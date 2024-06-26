<?php
  include 'assets/config/connexionDB.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $hp = $_POST['hp'];
    $attack = $_POST['attack'];
    $defense = $_POST['defense'];

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE pokemons SET name='$name', type='$type', hp='$hp', attack='$attack', defense='$defense' WHERE id=$id";
    } else {
        $sql = "INSERT INTO pokemons (name, type, hp, attack, defense) VALUES ('$name', '$type', '$hp', '$attack', '$defense')";
    }
    $conn->query($sql);
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM pokemons WHERE id=$id");
}


$result = $conn->query("SELECT * FROM pokemons");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        form { max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ddd; background-color: #fff; }
        label { display: block; margin: 10px 0 5px; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; margin-top: 10px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

<h1>Pokédex Admin</h1>

<form method="POST" action="index.php">
    <input type="hidden" name="id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" required>
    
    <label for="type">Type</label>
    <input type="text" id="type" name="type" required>
    
    <label for="hp">HP</label>
    <input type="number" id="hp" name="hp" required>
    
    <label for="attack">Attack</label>
    <input type="number" id="attack" name="attack" required>
    
    <label for="defense">Defense</label>
    <input type="number" id="defense" name="defense" required>
    
    <button type="submit">Save</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>HP</th>
        <th>Attack</th>
        <th>Defense</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['hp']; ?></td>
            <td><?php echo $row['attack']; ?></td>
            <td><?php echo $row['defense']; ?></td>
            <td>
                <a href="index.php?edit=<?php echo $row['id']; ?>">Edit</a>
                <a href="index.php?delete=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>

<?php
$conn->close();
?>


