<?php
session_start();
require('../connexionBdd.php');

require __DIR__ . '/../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

date_default_timezone_set('Europe/Paris');

if (!isset($_SESSION['panier']['idPanier'])) {
    header('Location: ../index.php');
}

ob_start();

$idPanier = $_SESSION['idPanier'];

$reqDetailPanier = $bdd->prepare('SELECT * FROM LIGNE_COMMANDE lc, PANIER p, PRODUIT prd WHERE lc.id_panier = p.id_panier AND lc.id_produit = prd.id_produit AND lc.id_panier = :idPanier');
$reqDetailPanier->execute(array(':idPanier' => $_SESSION['panier']['idPanier']));
$detailPanier = $reqDetailPanier->fetchAll(PDO::FETCH_ASSOC);

// VARIABLE PANIER
$montant = $detailPanier[0]['montant'];

// DÉCLARATION VARIABLE CLIENT
$nomDuClient = $_SESSION['nomUser'] . ' ' . $_SESSION['prenomUser'];
$dateTime = date('d-m-Y H:i:s');
$date = date('d-m-Y');
?>


    <page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">

        <page_footer>
            <hr/>
            <p>Facture édité, le <?php echo $dateTime; ?></p>
        </page_footer>

        <table style="vertical-align: top;">
            <tr>
                <td class="75p">
                    <strong>GALAXY GAMES</strong><br/>
                    Adresse : 683 Koontz Lane
                    Los Angeles, CA 90017 <br/>
                    <strong>SIRET:</strong> 5574662120<br/>
                    contact@galaxygames.com
                </td>
                <td class="25p">
                    <strong>Client: <?php echo $nomDuClient; ?></strong><br/>
                </td>
            </tr>
        </table>

        <table style="margin-top: 50px;">
            <tr>
                <td class="50p"><h2>Facture n° <?php echo 'FA-' . $_SESSION['idUser'] . rand(0, 100); ?></h2></td>
                <td class="50p" style="text-align: right;">Emis le <?php echo $date; ?></td>
            </tr>
        </table>

        <table style="margin-top: 30px;" class="border">
            <thead>
            <tr>
                <th class="60p">Produit</th>
                <th class="10p">Quantité</th>
                <th class="15p">Prix Unitaire</th>
                <th class="15p">Montant</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($detailPanier as $produit) { ?>
                <tr>
                    <td><?php echo $produit['nom_produit']; ?></td>
                    <td><?php echo $produit['quantite']; ?></td>
                    <td><?php echo $produit['prix_unitaire']; ?> €</td>
                    <td><?php echo $montant;
                        /*$price_tva = $produit['prix_unitaire']*1.2;
                        echo $price_tva;*/
                        ?> €
                    </td>

                    <?php
                    /*$total += $task['price'];
                    $total_tva += $price_tva;*/
                    ?>
                </tr>
            <?php } ?>

            <tr>
                <td class="space"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="2" class="no-border"></td>
                <td style="text-align: center;" rowspan="3"><strong>Total:</strong></td>
                <td>HT :</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td>TVA : <?php //echo ($total_tva - $total); ?></td>
            </tr>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td>TTC : <?php //echo $total_tva; ?> <?php echo $montant; ?> €</td>
            </tr>
            </tbody>
        </table>

    </page>

    <style type="text/css">
        table {
            width: 100%;
            color: #717375;
            font-family: helvetica;
            line-height: 5mm;
            border-collapse: collapse;
        }

        h2 {
            margin: 0;
            padding: 0;
        }

        p {
            margin: 5px;
        }

        .border th {
            border: 1px solid #000;
            color: white;
            background: #000;
            padding: 5px;
            font-weight: normal;
            font-size: 14px;
            text-align: center;
        }

        .border td {
            border: 1px solid #CFD1D2;
            padding: 5px 10px;
            text-align: center;
        }

        .no-border {
            border-right: 1px solid #CFD1D2;
            border-left: none;
            border-top: none;
            border-bottom: none;
        }

        .space {
            padding-top: 250px;
        }

        .10p {
            width: 10%;
        }

        .15p {
            width: 15%;
        }

        .25p {
            width: 25%;
        }

        .50p {
            width: 50%;
        }

        .60p {
            width: 60%;
        }

        .75p {
            width: 75%;
        }
    </style>

<?php

$content = ob_get_clean();

try {

    $pdf = new Html2Pdf('P', 'A4', 'fr');
    $pdf->pdf->SetAuthor('Vincent Mollineri');
    $pdf->pdf->SetTitle('Devis 14');
    $pdf->pdf->SetSubject('Création d\'un Portfolio');
    $pdf->pdf->SetKeywords('HTML2PDF, Devis, PHP');
    $pdf->writeHTML($content);
    $nameFile = 'Facture_' . microtime(true) . ".pdf";
    $pdf->output('/Applications/MAMP/htdocs/site_marchand/factures_pdfs/' . $nameFile, 'F');
    $pdf->output('facture.pdf');

} catch (HTML2PDF_exception $e) {
    die($e);
}
$ajourdhui = new DateTime();
$created = $ajourdhui->format('Y-m-d H:i:s');

$reqFacture = $bdd->prepare('INSERT INTO FACTURES (filename, path, id_panier, created) VALUES (:filename, :path, :id_panier, :created)');
$reqFacture->execute([':filename' => $nameFile, ':path' => 'pdf', ':id_panier' => $_SESSION['panier']['idPanier'], ':created' => $created]);

unset($_SESSION['panier']);
?>