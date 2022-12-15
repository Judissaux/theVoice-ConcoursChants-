<?php
require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

$html2pdf = new Html2Pdf();
$html2pdf->writeHTML("<page_footer> 
<p>
    Ma Super Boite, SASU au capital de X€<br />
    mon adresse<br />
    Immatriculé au RCS de Tours sous le numéro .......<br />
    TVA intracommunautaire : FR........
</p>
</page_footer>

<table><tr>

<td>
    <b>Facturé à :</b><br />
    $nomDuClient<br />
    $adresseDuClient
</td>
<td>
    <b>Détails :</b><br />
    Date de facturation : $date<br />
    Numéro de facture : $numeroDeFacture
</td>
</tr> </table>


");
$html2pdf->output();

?>
