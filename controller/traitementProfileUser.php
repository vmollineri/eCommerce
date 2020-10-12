<?php
require ('../connexionBdd.php');
session_start();

$idUser = $_SESSION['idUser'];
$password = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

if ($password == $confirmPassword) {
    $reqUpdatePassword = $bdd->prepare('UPDATE USER SET mdp = :newMdp WHERE id_user = :idUser');
    $reqUpdatePassword->execute([':newMdp' => $password, ':idUser' => $idUser]);

    unset($_SESSION['idUser']);

    header('Location: ../vues/connexion.php');
} else {
    header('Location: ../vues/profileUser.php?erreurConfirmation=1');
}
?>