<?php
session_start();
require('../connexionBdd.php');
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

    <title>Galaxy Games | Mon Panier</title>
</head>

<body>
<!-- TOPBAR DU SITE -->
<?php
$hrefIndex = '../index.php';
$hrefPanier = 'panier.php';
$hrefInscription = 'inscription.php';
$hrefConnexion = 'connexion.php';
$hrefDeconnexion = 'deconnexion.php';
$hrefProfileUser = 'profileUser.php';
$srcIcone = '../modele/images/videogames.png';
include('header.php');
?>
<!-- TOPBAR DU SITE -->

<!-- ENTÊTE DU PANIER CLIENT -->
<section class="jumbotron text-center titleLvl1">
    <div class="container">
        <h1 class="jumbotron-heading titleLvl1">Votre panier</h1>
    </div>
</section>
<!-- ENTÊTE DU PANIER CLIENT -->

<!-- PRÉSENTATION DU PANIER CLIENT -->
<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <?php
                $reqDetailPanier = $bdd->prepare('SELECT * FROM LIGNE_COMMANDE lc, PANIER p, PRODUIT prd WHERE lc.id_panier = p.id_panier AND lc.id_produit = prd.id_produit AND lc.id_panier = :idPanier');
                $reqDetailPanier->execute(array(':idPanier' => $_SESSION['panier']['idPanier']));
                $detailPanier = $reqDetailPanier->fetchAll(PDO::FETCH_ASSOC);

                if (count($detailPanier) == 0) {
                    echo '<p class="alert alert-danger" style="text-align: center;">Votre panier est vide.</p>';
                } else {
                    ?>
                    <table class="table table-striped">
                        <thead>
                        <tr style="text-align: center">

                            <th scope="col">Mes Produits</th>
                            <th scope="col">Quantités</th>
                            <th scope="col">Prix unitaire</th>
                            <th scope="col">Prix total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        foreach ($detailPanier as $produit) {

                            echo '<form method="POST" id="formProduit' . $produit['id_produit'] . '" action="../controller/traitementPanier.php">';
                            echo '<tr>';
                            echo '<td>' . $produit['nom_produit'] . '</td>';
                            echo '<td style="display:flex;"><select class="form-control" id="quantiteProd" name="quantite" style="width:50%; margin:auto;" onchange="changeQuantite()">';

                            for ($i = 1; $i <= $produit['stock']; $i++) {
                                if ($produit['quantite'] == $i) {
                                    echo '<option value="' . $i . '" selected>' . $i . '</option>';
                                } else {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                            }

                            echo '</select></td>';
                            echo '<td class="text-right">' . $produit['prix_unitaire'] . ' €</td>';
                            $totalProduit = $produit['prix_unitaire'] * $produit['quantite'];

                            echo '<td class="text-right">' . $totalProduit . ' €</td>';
                            echo '<input type="hidden" name="mntPanier" id="mntPanier" class="form-control" value="' . $produit['montant'] . '">';
                            echo '<input type="hidden" name="oldQte" id="oldQte" class="form-control" value="' . $produit['quantite'] . '">';
                            echo '<input type="hidden" name="prix_unitaire" id="prix_unitaireProd" class="form-control" value="' . $produit['prix_unitaire'] . '">';
                            echo '<input type="hidden" name="id_produit" id="idProd" class="form-control" value="' . $produit['id_produit'] . '">';
                            echo '<td class="text-right"><button type="submit" name="supprimerProduit" class="btn btn-sm btn-danger"><i class="fa fa-trash"><img src="https://img.icons8.com/material-rounded/24/000000/delete-sign.png"/></i></button></td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            //echo '<td><strong>Total TTC :</strong></td>';
                            //echo '<td class="text-right"><strong></strong></td>
                            echo '</tr>';
                            echo '</form>';
                        }

                        echo '<tr>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td></td>';
                        echo '<td><strong>Total TTC :</strong></td>';
                        echo '<td class="text-right"><strong>' . $produit['montant'] . ' €</strong></td>';
                        echo '</tr>';
                        ?>

                        </tbody>
                    </table>
                    <?php
                }
                ?>
            </div>
        </div>

        <?php
        if (COUNT($detailPanier) > 0) {
            ?>
            <div class="col mb-2">
                <div class="row">
                    <div class="col-sm-12  col-md-6">
                        <a class="btn btn-lg btn-block btn-warning" href="../index.php" role="button">Retour aux
                            achats</a>
                    </div>
                    <div class="col-sm-12 col-md-6 text-right">
                        <?php
                        echo '<form method="POST" action="facture.php" target="_blank">';
                        echo '<div>';
                        if (isset($_SESSION['idUser'])) {
                            echo '<button name="Valider mon panier" class="btn btn-lg btn-block btn-primary" type="submit" onclick="redirectAccueil()">Valider mon panier</button>';
                        } else {
                            echo '<p class="alert alert-danger text-center" style="font-size: 1.25rem">Pour valider le panier, veuillez vous connecter.</p>';
                        }

                        echo '</div>';
                        echo '</form>'; ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!-- PRÉSENTATION DU PANIER CLIENT -->

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function changeQuantite() {
        // VALIDATION DU SELECTEUR QTE PRODUIT EN JS
        /* let idForm = 'formProduit' + idProduit;
         let form = document.getElementById(idForm);
         form.submit();*/
        var prixProd = $('#prix_unitaireProd').val();
        var oldQte = $('#oldQte').val();
        var newQte = $('#quantiteProd').val();
        var idProd = $('#idProd').val();

        window.location = '../controller/traitementPanier.php?modifierQte=1&prix_unitaire=' + prixProd + '&quantite=' + newQte + '&id_produit=' + idProd + '&oldQte=' + oldQte;

    }

    function redirectAccueil(){
        window.location = '../index.php';
    }
</script>
</body>

</html>