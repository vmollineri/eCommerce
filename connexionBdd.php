<?php
$user = "root";
$pass = "root";
$dsn = 'mysql:host=localhost:8889;dbname=site_marchand';

$bdd = new PDO('mysql:host=localhost:8889;dbname=site_marchand', $user, $pass);


try {
    $bdd = new PDO($dsn, $user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
?>