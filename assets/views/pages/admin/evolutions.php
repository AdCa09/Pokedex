<?php
$adminName = $_SESSION['user'];

$title = "Evolution";
require_once __DIR__ . '../../../partials/header.php';
echo '<h1>Hello, ' . htmlspecialchars($adminName);
'</h1>' 
?>

<head>
    <link href="../../assets/public/css/dashboard.css" type="text/css" rel="stylesheet">
</head>
<h2>Gestion des </h2>


<?php
require_once __DIR__ . '../../../partials/footer.php';
?>