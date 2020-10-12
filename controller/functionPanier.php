<?php

function creationPanier($bdd)
{
    $montant = $_POST['prix_unitaire'] * $_POST['quantite'];

    if (!isset($_SESSION['panier'])) {
        $datetime = new DateTime();
        $dateCreate = $datetime->format('Y-m-d H:i:s');

        if (isset($_SESSION['idUser'])) {
            $idUser = $_SESSION['idUser'];
            $reqInsertPanier = 'INSERT INTO PANIER (id_user, montant, date_create) VALUES (:idUser, :montant, :dateCreate)';
            $tabExecute = [':idUser' => $idUser, ':montant' => $montant, ':dateCreate' => $dateCreate];
        } else {
            $timestamp = time();
            $reqInsertPanier = 'INSERT INTO PANIER (timestamp_user, montant, date_create) VALUES (:timestampUser, :montant, :dateCreate)';
            $tabExecute = [':timestampUser' => $timestamp, ':montant' => $montant, ':dateCreate' => $dateCreate];
        }

        // AJOUT DU PANIER EN BDD
        $requeteInsertPanier = $bdd->prepare($reqInsertPanier);
        $requeteInsertPanier->execute($tabExecute);

        $reqIdPanier = $bdd->prepare('SELECT * FROM PANIER WHERE id_panier = (SELECT MAX(id_panier) FROM PANIER)');
        $reqIdPanier->execute();
        $idPanier = $reqIdPanier->fetch(PDO::FETCH_ASSOC);

        // ON ENREGISTRE LE PANIER EN SESSION
        $_SESSION['panier'] = array();
        $_SESSION['panier']['idPanier'] = $idPanier['id_panier'];
        $_SESSION['panier']['montantPanier'] = $idPanier['montant'];

    } else {
        $reqUpdatePanier = $bdd->prepare('UPDATE PANIER SET montant = montant + :montant WHERE id_panier = :idPanier');
        $reqUpdatePanier->execute(array(':montant' => $montant, ':idPanier' => $_SESSION['panier']['idPanier']));
    }
    return true;
}

function ajouterArticle($bdd, $nomProduit, $stockProduit, $prixProduit)
{

    // SI LE PANIER EXISTE
    if (creationPanier($bdd)) {
        // ON INSÈRE LE PRODUIT EN BDD DANS LIGNE_COMMANDE
        $requeteInsertProduit = $bdd->prepare('INSERT INTO LIGNE_COMMANDE (id_produit, id_panier, quantite) VALUES (:idProduit, :idPanier, :qte)');
        $requeteInsertProduit->execute(array(':idProduit' => $_POST['idProduit'], ':idPanier' => $_SESSION['panier']['idPanier'], ':qte' => $_POST['quantite']));
    } else {
        echo "Un problème est survenu veuillez, contacter l'administrateur du site.";
    }
}

function recupMontantPanier($bdd)
{
    // RECUPERER LA QUANTITE DANS LIGNE_COMMANDE DU PRODUIT QU'ON VEUT SUPPRIMER
    $reqMtnPanier = $bdd->prepare('SELECT montant FROM PANIER WHERE id_panier = :idPanier');
    $reqMtnPanier->execute(array(':idPanier' => $_SESSION['panier']['idPanier']));
    $montantPanier = $reqMtnPanier->fetch();

    return $montantPanier['montant'];
}


function supprimerArticle($idProduit, $prixUnit, $oldQte, $mntPanier, $bdd)
{
    // CALCUL MONTANT PRODUIT
    $montantProduit = $oldQte * $prixUnit;

    $newMntPanier = $mntPanier - $montantProduit;

    // REQUETE DELETE PRODUIT
    $requeteDeleteProduit = $bdd->prepare('DELETE FROM LIGNE_COMMANDE WHERE id_produit = :idProduit AND id_panier = :idPanier');
    $requeteDeleteProduit->execute(array(':idProduit' => $idProduit, ':idPanier' => $_SESSION['panier']['idPanier']));

    if ($newMntPanier == 0) {

        // MAJ MONTANT PANIER
        $reqDeletePanier = $bdd->prepare('DELETE FROM PANIER WHERE id_panier = :idPanier');
        $reqDeletePanier->execute(array(':idPanier' => $_SESSION['panier']['idPanier']));
        unset($_SESSION['panier']);
    } else {
        // MAJ MONTANT PANIER
        $reqUpdateMtnPanier = $bdd->prepare('UPDATE PANIER SET montant = :newMntPanier WHERE id_panier = :idPanier');
        $reqUpdateMtnPanier->execute(array(':newMntPanier' => $newMntPanier, ':idPanier' => $_SESSION['panier']['idPanier']));

    }
}

function modifierQteArticle($idProduit, $newQte, $oldQte, $prixUnit, $bdd)
{

    $qteAjoutee = $newQte - $oldQte;

    $montantPanier = recupMontantPanier($bdd);

    $newMntPanier = $montantPanier + ($qteAjoutee * $prixUnit);

    // MAJ MONTANT PANIER
    $reqUpdateQte = $bdd->prepare('UPDATE PANIER SET montant = :newMntPanier WHERE id_panier = :idPanier');
    $reqUpdateQte->execute(array(':newMntPanier' => $newMntPanier, ':idPanier' => $_SESSION['panier']['idPanier']));

    // MAJ QUANTITE PRODUIT
    $reqUpdateQte = $bdd->prepare('UPDATE LIGNE_COMMANDE SET quantite = :newQte WHERE id_panier = :idPanier AND id_produit = :idProduit');
    $reqUpdateQte->execute(array(':newQte' => $newQte, ':idPanier' => $_SESSION['panier']['idPanier'], ':idProduit' => $idProduit));

}
