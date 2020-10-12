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

    <title>Galaxy Games | Réinitialiser mot de passe</title>
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

<?php
if (isset($_GET['erreur'])) {
    $erreur = (int)$_GET['erreur'];
    switch ($erreur) {
        case 1:
            $message= '<div class="alert alert-danger text-center mt-3" style="font-size: 1.25rem">Vous n\'existez pas !</div>';
            break;
        case 2:
            $message = '<div class="alert alert-danger text-center mt-3" style="font-size: 1.25rem">Adresse mail non valide !</div>';
            break;
        case 3:
            $message = '<div class="alert alert-danger text-center mt-3" style="font-size: 1.25rem">Veuillez remplir le champ !</div>';
    }
}
?>

<div class="container mt-5 p-0">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h1 class="card-title text-center">Réinitialiser mon mot de passe</h1>
                    <form class="form-signin" method="POST" action="../controller/traitementReinitPassword.php">
                        <div class="form-label-group">
                            <label for="mailClient">Email</label>
                            <input type="email" id="mailClient" name="mailClient" class="form-control"
                                   placeholder="Votre adresse mail">
                        </div>
                        <button class="btn btn-lg btn-block btn-primary text-uppercase mt-3" type="submit">
                            Réinitialiser
                            mot de passe
                        </button>
                    </form>
                    <?php if (isset($message)) {
                        echo $message;
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FORMULAIRE DE CONNEXION -->

</body>
</html>
