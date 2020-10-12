<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('connexionBdd.php');
require('controller/function.php');

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
    <link rel="stylesheet" href="./modele/style/index.css">
    <link rel="stylesheet" href="./modele/style/topBar.css">

    <title>Accueil | Nos produits</title>
</head>

<body>
<!-- TOPBAR DU SITE -->
<?php
$hrefIndex = 'index.php';
$hrefPanier = 'vues/panier.php';
$hrefInscription = 'vues/inscription.php';
$hrefConnexion = 'vues/connexion.php';
$hrefDeconnexion = 'vues/deconnexion.php';
$srcIcone = 'modele/images/videogames.png';
$hrefProfileUser = 'vues/profileUser.php';

include('vues/header.php');

?>

<div class="jumbotron jumbotron-fluid customJumbotron">
    <div class="container">
        <h1 class="display-4 customTitleLvl1">Galaxy Games</h1>
        <p class="lead">
            Votre fournisseur de jeux vidéos, console & accesoires gaming !
        </p>
        <hr class="my-4">
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit assumenda fugiat sed totam pariatur. Voluptatum
            dignissimos reiciendis vel sed facere a sequi nihil modi. Odio et animi architecto dignissimos
            ipsum.Reiciendis error voluptas exercitationem dolorem nemo ducimus quod rerum nobis aut, ipsa officia
            repellat minima ullam repudiandae temporibus, pariatur accusamus quos corrupti architecto dicta harum, omnis
            unde tenetur distinctio. Doloremque?
        </p>
    </div>
</div>

<div class="banniere">
    <img src="modele/images/banniere.jpg" class="img-fluid" alt="Bannière du site">
</div>
<!-- TOPBAR DU SITE -->

<!-- CATÉGORIE JEUX  -->

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Nos jeux</h1>
        <hr class="my-4">
        <p>
            Un large choix de jeux pour PS4, Xbox One & Nintendo Switch rien que pour TOI ! Vous hommes & femmes qui
            aimais le gaming, vous trouverez une large gamme des blockbusters & jeux AAA ! :D.
        </p>
    </div>
</div>

<!-- CATÉGORIE JEUX  -->

<!-- AFFICHAGE DES PRODUITS SUR L'INDEX -->

<div class="container-fluid resizeContainer">
    <div class="row">
        <div class="card-deck">
            <?php
            $produits = afficheProduit($bdd);

            foreach ($produits as $produit) {

                echo '<div class="col-lg-4 col-sm-12 divProduit">';
                echo '<div class="card m-3">';
                echo '<img src=' . $produit['img'] . ' class="card-img-top img-fluid customImage" alt="Image produit">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $produit['nom_produit'] . '</h5>';
                echo '<p class="card-text">' . $produit['description'] . '</p>';
                echo '<h5 class="card-text text-right">' . $produit['prix_unitaire'] . '€ </h5>';
                echo '<hr>';
                echo '<div class="form-label-group mt-2">';
                if ($produit['stock'] == 0) {
                    echo "Rupture de stock";
                } else {
                    echo '<form method="POST" action="controller/traitementPanier.php">';
                    echo '<div>';
                    echo '<input type="hidden" name="prix_unitaire" class="form-control" value="' . $produit['prix_unitaire'] . '">';
                    echo '<input type="hidden" name="idProduit" class="form-control" value="' . $produit['id_produit'] . '">';
                    echo '<input type="hidden" name="nom_produit" class="form-control" value="' . $produit['nom_produit'] . '">';
                    echo '<input type="number" name="quantite" class="form-control" min="0" max="' . $produit['stock'] . '" value="1">';
                    echo '</div>';
                    echo '<button name="ajouter" class="btn btn-lg btn-primary btn-block mt-2" type="submit">Ajouter au panier</button>';
                    echo '</form>';
                }
                echo '</div>';

                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<!-- AFFICHAGE CATÉGORIE JEUX SUR L'INDEX -->

<!-- AFFICHAGE CATÉGORIE CONSOLE SUR L'INDEX -->

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Nos consoles</h1>
        <hr class="my-4">
        <p>
            Nous vous présentons une large sélection de console next-gen & du rétro gaming. Si vous cherchiez un endroit
            ou trouver des pétites, vous êtes au bon endroit ;) ! Toutes nos consoles, d'occasions sont testés, nettoyer
            et remise à neuf le cas échéant, et le petit bonus rien que pour vous faire plaisir nous offrons une garanti
            de 6 mois pour toutes consoles rétro gaming achetés !
        </p>
    </div>
</div>

<!-- AFFICHAGE CATÉGORIE ACCESSOIRES SUR L'INDEX -->


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
