<?php
require('../connexionBdd.php');
session_start();

$nom = $_POST['inputName'];
$prenom = $_POST['inputPrenom'];
$email = $_POST['inputEmail'];
$dateNaissance = $_POST['inputNaissance'];
$mdp = $_POST['inputPassword'];
//$verifMdp = $_POST['inputVerificationPassword'];

$requeteEmailExiste = $bdd->prepare('SELECT * FROM USER WHERE email = :email');
$requeteEmailExiste->execute([':email'=>$email]);
$emailExiste = $requeteEmailExiste->fetch();

if (empty($emailExiste)) {
    // On insère les données saisies dans le formulaire
    $requeteCreateUser = $bdd->prepare('INSERT INTO USER (nom, prenom, date_naissance, email, mdp) VALUES (:nom, :prenom, :dateNaissance, :email, :mdp)');
    $requeteCreateUser->execute([':nom' => $nom, ':prenom' => $prenom, ':dateNaissance' => $dateNaissance, ':email' => $email, ':mdp' => $mdp]);

    header("location: ../vues/inscription.php?success=1");

    } else {
        header("location: ../vues/inscription.php?erreur=1");
    }

?>
