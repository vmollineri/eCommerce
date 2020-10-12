<?php
session_start();
require('../connexionBdd.php');

$idUser = $_SESSION['prenomUser'];
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

    <title>Galaxy Games | Mon profil</title>
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
<!-- FORMULAIRE PROFILE USER -->

<?php
$idUser = $_SESSION['idUser'];

$reqInformationClient = $bdd->prepare('SELECT nom, prenom, date_naissance, email FROM USER WHERE id_user = :idUser');
$reqInformationClient->execute([':idUser' => $idUser]);
$user = $reqInformationClient->fetch();
?>

<div class="container mt-5 p-0">
    <div class="row justify-content-around">
        <div class="col-sm-9 col-md-7 col-lg-5">
            <div class="card card-signin my-5">
                <div class="card-body">

                    <h1 class="card-title text-center">Mes informations personnelles</h1>

                    <form class="form">
                        <div class="form-label-group">
                            <label for="nomClient">Votre nom</label>
                            <input type="text" id="nomClient" name="nomClient" class="form-control"
                                   value="<?php echo $user['nom'] ?>">
                        </div>

                        <div class="form-label-group mt-2">
                            <label for="prenomClient">Votre prénom</label>
                            <input type="text" id="prenomClient" name="prenomClient" class="form-control"
                                   value="<?php echo $user['prenom'] ?>">
                        </div>

                        <div class="form-label-group mt-2">
                            <label for="mailClient">Votre mail</label>
                            <input type="email" id="mailClient" name="mailClient" class="form-control"
                                   value="<?php echo $user['email'] ?>">
                        </div>

                        <div class="form-label-group mt-2">
                            <label for="birthdayClient">Votre date de naissance</label>
                            <input type="date" id="birthdayClient" name="birthdayClient" class="form-control"
                                   value="<?php echo $user['date_naissance'] ?>">
                        </div>

                        <div class="form-label-group mt-3">
                            <a class="btn btn-lg btn-block btn-dark" href="pageFactureClient.php" role="button">Mes factures</a>
                        </div>
                        </span>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-7 col-lg-5 mt-5">
            <div class="card card-signin my-5" style="margin-top: 0 !important">
                <div class="card-body">

                    <h1 class="card-title text-center">Modifier mot de passe</h1>

                    <a href="#" onclick="showStuff('answer1'); return false;">Click to Open Me</a>
                    <div id="answer1" <?php if (!isset($_GET['erreurConfirmation'])) { ?> style="display: none;" <?php } ?>>

                        <form class="form" action="../controller/traitementProfileUser.php" method="POST">
                            <div class="form-label-group">
                                <label for="newPassword" style="margin: 10px !important">Nouveau mot de passe
                                    :</label>
                                <input type="password" id="newPassword" name="newPassword" class="form-control"
                                       value="">
                            </div>
                            <div class="form-label-group">
                                <label for="confirmPassword"
                                       style="margin: 10px !important">Confirmer le mot de passe :</label>
                                <input type="password" id="confirmPassword" name="confirmPassword"
                                       class="form-control"
                                       value="">
                                <button class="btn btn-block btn-lg btn-dark my-4" type="submit">Valider</button>
                            </div>
                            <?php
                            if (isset($_GET['erreurConfirmation'])) {
                                if ($_GET['erreurConfirmation'] == 1) {
                                    echo '<span class="message_erreur pl-5">Les mots de passe ne correspondent pas !</span>';
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showStuff(id) {
        document.getElementById(id).style.display = 'block';
    }

    function validate() {
        let a = document.getElementById('newPassword').value;
        let b = document.getElementById('confirmPassword').value;

        if (a != b) {
            alert("Les mots de passes ne correspondent pas !");
            return false;
        } else {
            alert("La modification de votre mot de passe est prise en compte !");
            return true;
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
</body>
</html>
