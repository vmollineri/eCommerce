<?php
require_once('../connexionBdd.php');
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS & Custom CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../modele/style/index.css">
    <link rel="stylesheet" href="../modele/style/topBar.css">

    <title>Galaxy Games | Page Connexion</title>
</head>

<body>
<!-- TOPBAR DU SITE -->
<?php

$hrefIndex = '../index.php';
$hrefPanier = 'panier.php';
$hrefInscription = 'inscription.php';
$hrefConnexion = 'connexion.php';
$hrefDeconnexion = 'deconnexion.php';
$srcIcone = '../modele/images/videogames.png';
include('header.php');

?>
<!-- TOPBAR DU SITE -->

<!-- FORMULAIRE DE CONNEXION -->

<div class="container mt-5 p-0">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h1 class="card-title text-center">Connexion</h1>
                    <form class="form-signin" method="POST" action="../controller/traitementConnexion.php">
                        <?php
                        if (isset($_GET["erreur"])) {
                            if ($_GET["erreur"] == 1) {
                                echo '<div class="message_erreur"><p>Identifiants incorrects ! Réessayez.</p></div>';
                            }
                        }
                        ?>
                        <div class="form-label-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" id="inputEmail" name="inputEmail" class="form-control"
                                   placeholder="Votre adresse mail" required autofocus>
                        </div>

                        <div class="form-label-group mt-2">
                            <label for="inputPassword">Password</label>
                            <input type="password" id="inputPassword" name="inputPassword" class="form-control"
                                   placeholder="Votre mot de passe" required>
                        </div>

                        <div class="custom-control custom-checkbox mb-3 mt-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Se souvenir de moi</label>
                        </div>
                        <button class="btn btn-lg btn-block btn-primary text-uppercase" type="submit">Se connecter
                        </button>
                        <hr class="my-4">
                        <a class="d-block text-center mt-2 small" href="reinitPassword.php">Mot de passe oublié ?</a>
                        <a class="d-block text-center mt-2 small" href="inscription.php">Inscription</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FORMULAIRE DE CONNEXION -->


<!-- BIBLIOTHÈQUE JS BOOTSTRAP -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>

</html>
