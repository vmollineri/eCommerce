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
    <title>Galaxy Games | Mes factures</title>
</head>
<body>
<?php
$hrefIndex = '../index.php';
$hrefPanier = 'panier.php';
$hrefInscription = 'inscription.php';
$hrefConnexion = 'connexion.php';
$hrefDeconnexion = 'deconnexion.php';
$srcIcone = '../modele/images/videogames.png';
$hrefProfileUser = 'profileUser.php';

include('header.php');
?>

<?php
$idUser = $_SESSION['idUser'];

// REQUETE ID FACTURE POUR AFFICHAGE TABLEAU

$reqFacturesClient = $bdd->prepare('SELECT id_facture, filename, created FROM FACTURES INNER JOIN PANIER ON FACTURES.id_panier = PANIER.id_panier AND id_user = :idUser');
$reqFacturesClient->execute([':idUser' => $idUser]);
$facturesClient = $reqFacturesClient->fetchAll();

?>
<div class="container" style="margin-top: 100px">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Date commande</th>
            <th scope="col">ID Facture</th>
            <th scope="col">Télécharger facture</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($facturesClient as $facture) {

        ?>
        <tr>
            <td><?php echo $facture['created']; ?></td>
            <td><?php echo $facture['id_facture']; ?></td>
            <td><a href="<?php echo '../factures_pdfs/'.$facture['filename']; ?>" target="_blank"><?php echo $facture['filename']; ?></a></td>
        </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
