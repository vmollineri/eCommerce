<?php
require('../connexionBdd.php');
session_start();

$email = $_POST['inputEmail'];
$mdp = $_POST['inputPassword'];



$reqConnexionUser = $bdd->prepare('SELECT * FROM USER WHERE email = :email AND mdp = :mdp');
$reqConnexionUser->execute([':email' => $email, ':mdp' => $mdp]);
$user = $reqConnexionUser->fetch();

if (empty($user)) {
    header('Location:../vues/connexion.php?erreur=1');

} else {
    $_SESSION['idUser'] = $user['id_user'];
    $_SESSION['nomUser'] = $user['nom'];
    $_SESSION['prenomUser'] = $user['prenom'];

    if (isset($_SESSION['panier'])){
        $reqUpdateQte = $bdd->prepare('UPDATE PANIER SET id_user = :idUser WHERE id_panier = :idPanier');
        $reqUpdateQte->execute(array(':idUser' => $_SESSION['idUser'], ':idPanier' => $_SESSION['panier']['idPanier']));
    }
    header("location:../index.php");
}
?>
