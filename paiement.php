
<?php 
session_start();
if(!$_SESSION["user"]){
    header("location: index.php");
    exit;
}
$title = "Paiement";
include "header.php";
include "navbar_connected.php";
?>
<body class='bgpaiement'>
<div class='d-flex my-5 p-5 flex-column align-item-center text-white'>
    <h2 class='text-center my-5' >Paiement à transmettre par chéque <img src="Images/cheque.gif" width="75px" alt="chéque"></h2>
    <h3 class='text-center my-3'>Montant de la cotisation : 100€</h3>
    <table class='rounded d-flex justify-content-center m-auto p-3 table-light w-auto'>
    <tr>
        <td><img src="Images/entreprise.png" alt="Entreprise" width="50px"></td>
        <td class='pl-3'><h3> Endemol France</h3></td>
    </tr> 
    <tr>
        <td><img src="Images/adresse.png" alt="Adresse" width="50px"></td>
        <td class='pl-3'>
            <h6> 10 Rue Waldeck Rochet <br>
                 Bâtiment 521 <br>
                 93300 AUBERVILLIERS
            </h6></td>
    </tr> 
    <tr>
        <td><img src="Images/telephoner.gif" alt="Numéro de téléphone" width="50px"></td>
        <td class='pl-3'><h3> +33 (0)1 53 56 40 00</h3></td>
    </tr> 
</table>    
</div>


    
</body>
</html>