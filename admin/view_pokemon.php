<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include '../assets/config/connexionDB.php';

$sql = "SELECT * FROM pokemon";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Pokemon</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>All Pokemon</h2>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
    <table>
        <tr>
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
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['image']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['hp']; ?></td>
                <td><?php echo $row['attack']; ?></td>
                <td><?php echo $row['defense']; ?></td>
                <td><?php echo $row['specific_defense']; ?></td>
                <td><?php echo $row['specific_attack']; ?></td>
                <td><?php echo $row['speed']; ?></td>
                <td>
                    <a href="edit_pokemon.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete_pokemon.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this Pokemon?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
