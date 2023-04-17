<?php 
session_start();
ob_start();

$nomDuClient=$_SESSION['user']['nom'];
$prenomDuClient=$_SESSION['user']['prenom']; 
$adresseDuClient=$_SESSION['user']['age'];
$numeroDeTelDuClient=$_SESSION['user']['email'];
$date = "Facturé le " . date("d/m/Y") ;
$facture="Facture n°". (rand(1, 10000) . "<br>");
$prix="100€";

$int = time() + 825626 ;
setlocale(LC_TIME, 'fr_FR.utf8');
$daterdv = strftime("%e %B %Y,  14h00", $int);
?>
<style>
 .premiertable{width: 100%; }
 .deuxiemetable{width: 100%; }
.client{  text-align:center;width: 100%;}
.date{ text-align:center; width: 100%;}
.styleEcriture{font-size: large;border: 1px solid black;}
.bordureEntreprise{border:solid 1px black ; width:50%;text-align:center}
.bordureClientUne{ width:50%; }
.BordureDeux{border:solid 1px black ; width:50%; }
.imgtest{text-align:center;}
.footer{font-style: italic;}

</style>

<page  backimg="../Images/logo.png" backimgx="right" backimgy="top" backimgw="25%" backtop="20mm" backleft="10mm" backright="10mm" >
    
    <table class="premiertable" >
        <tr>
            <td >
                <div class="bordureEntreprise">
            <p class="styleEcriture">
                
            <b>Identifcation du prestataire</b><br><br>
            <strong>Nom</strong>: The voice<br>
            <strong>Adresse</strong>: Champ de Mars, 5 Av. Anatole France, 75007 Paris<br>
            <strong>Numéro de SIREN</strong>: 362 521 879<br>
            <strong>Numéro de téléphone</strong>: 0999999999<br>
            Enregistré au RCS/RM de Paris</p>
            </div>
            </td>
            </tr>
            <tr class=>
                <td class="client"  >
                    
                <div class="bordureClientUne">
                <div class="BordureDeux">
                <p class="styleEcriture"><b>Facturé à :</b><br><br>
                <?php echo $nomDuClient ;?><br>
                <?php echo $prenomDuClient ;?><br />
                <?php echo $adresseDuClient.' ans' ;?><br />
                <?php echo $numeroDeTelDuClient ;?>
                </p>
                </div>
                </div>
                </td>
            </tr>
    </table>
    <table class="deuxiemetable">
        <tr>
        <td class="date">
        <br><br><br><br>
            <p class=" styleEcriture"><strong><?php echo $facture ?></strong></p>
             <p class=" styleEcriture"><?php echo $date ?></p>
             <br><br><br><br><br>
         </td>
        </tr>
        <tr>
            <td style="text-align:center; margin-top:10px;">
                Nous vous confirmons la réception de votre paiement d'un montant de <?php echo $prix ?>.<br><br>
                Nous vous invitons a vous présentez le <?php echo $daterdv ?> pour votre prestation.<br><br>
                Veuillez recevoir l'assurance de ma considération distinguée.<br><br>
                Thevoice DIRECTOR <br><br><br><br>
            </td>
        </tr>
        <tr><td>
            <div class="imgtest">
            <img src="../Images/tampon.jpg" style="text-align:center" >
            </div>
        </td></tr>
    </table>
    <page_footer > 
    <p class="footer">
        Thevoice, SAS au capital de 10000000€<br>
        Champ de Mars, 5 Av. Anatole France, 75007 Paris<br>
        Immatriculé au RCS de Paris sous le numéro RCS PARIS B 517 403 572<br>
        TVA intracommunautaire : FR 53 157896342
    </p>
    </page_footer>
</page>

    
  


<?php
$content=ob_get_clean();
require __DIR__.'/vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
try{
    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->output('facture.pdf','D');
    
}catch(Html2PdfException $e){
    die($e);
}



?>