<?php
require('../connexionBdd.php');
session_start();

// CODE DE RÉCUPERATION PASSWORD

if (isset($_POST['mailClient'])) {
    if (!empty($_POST['mailClient'])) {
        $recupMail = htmlspecialchars($_POST['mailClient']);
        if (filter_var($recupMail, FILTER_VALIDATE_EMAIL)) {
            $mailExiste = $bdd->prepare('SELECT id_user, prenom FROM USER WHERE email = :email');
            $mailExiste->execute([':email' => $recupMail]);
            $mailExisteCount = $mailExiste->rowCount();
            if ($mailExisteCount == 1) {
                $firstnameClient = $mailExiste->fetch();
                $firstnameClient = $firstnameClient['prenom'];

                $_SESSION['mailClient'] = $recupMail;
                $recupCode = "";

                for ($i = 0; $i < 8; $i++) {
                    $recupCode .= mt_rand(0, 9);
                }

                $mailRecupExiste = $bdd->prepare('SELECT id_recup FROM RECUPERATION WHERE email = :email');
                $mailRecupExiste->execute([':email' => $recupMail]);
                $mailRecupExiste = $mailRecupExiste->rowCount();

                if ($mailRecupExiste == 1) {
                    $insertCode = $bdd->prepare('UPDATE RECUPERATION SET code = :code WHERE email = :email ');
                    $insertCode->execute([':code' => $recupCode, ':email' => $recupMail]);
                } else {
                    $insertCode = $bdd->prepare('INSERT INTO RECUPERATION(email, code) VALUES(:email, :code)');
                    $insertCode->execute([':email' => $recupMail, ':code' => $recupCode]);
                }
            } else {
                header("Location: ../vues/reinitPassword.php?erreur=1");
            }
        } else {
            header("Location: ../vues/reinitPassword.php?erreur=2");
        }
    } else {
        header("Location: ../vues/reinitPassword.php?erreur=3");
    }
}
?>
