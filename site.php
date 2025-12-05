<?php

set_include_path("./src");

require_once('/users/houssou251/private/mysql_config.php');
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
require_once("model/AnimalStorageMySQL.php");

// Créer l'instance PDO avec les constantes
try {
    $pdo = new PDO(
        'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . ';charset=utf8mb4',
        MYSQL_USER,
        MYSQL_PASSWORD
    );
    
    // Configuration PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

session_start();

// Gérer le feedback
$feedback = null;
if (isset($_SESSION['feedback'])) {
    $feedback = $_SESSION['feedback'];
    unset($_SESSION['feedback']);
}

// Passer PDO au constructeur
$animalStorage = new \Model\AnimalStorageMySQL($pdo);

require_once("PathInfoRouter.php");

$router = new PathInfoRouter();
$router->main($animalStorage, $feedback);
?>
