<?php
require('functionPanier.php');
require('../connexionBdd.php');
session_start();
//-------------------------------------

// FUNCTIONS PANIER

if(isset($_POST['ajouter']))
{
    $prixProduit  =  $_POST["prix_unitaire"];
    $nomProduit =  $_POST["nom_produit"];
    $stockProduit = $_POST["quantite" ];

    ajouterArticle($bdd, $nomProduit, $stockProduit, $prixProduit);
}

if(isset($_POST['supprimerProduit']))
{
    $idProduit =  $_POST["id_produit"];
    $prixUnit = $_POST["prix_unitaire"];
    $oldQte = $_POST["oldQte"];
    $mntPanier = $_POST["mntPanier"];
    supprimerArticle($idProduit, $prixUnit,$oldQte, $mntPanier, $bdd);
}

if(isset($_GET["modifierQte"]))
{
    $idProduit = $_GET['id_produit'];
    $oldQte = $_GET['oldQte'];
    $newQte = $_GET['quantite'];
    $prixUnit = $_GET["prix_unitaire"];
    modifierQTeArticle($idProduit, $newQte, $oldQte, $prixUnit, $bdd);
}

header('Location:../vues/panier.php');
?>
