<?php
// Connexion à la base de données
$host = 'localhost';
$db   = 'test_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Récupération des données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête vulnérable à l'injection SQL
    $stmt = $pdo->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");

    if ($user = $stmt->fetch()) {
        echo "<h2 style='color:green;text-align:center;'>Connexion réussie ! Bienvenue " . htmlspecialchars($user['username']) . "</h2>";
    } else {
        echo "<h2 style='color:red;text-align:center;'>Échec de connexion. Identifiants incorrects.</h2>";
    }

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>