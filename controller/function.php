<?php
// Fonction d'affichage dynamique des produits sur l'index
function afficheProduit($bdd)
{

    $requete = $bdd->prepare('SELECT * FROM PRODUIT');
    $requete->execute();
    $produits = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $produits;
}

?>
