<?php 
session_start();
if(!$_SESSION["user"]){
    header("location: index.php");
    exit;
}
$title = "Accueil";
?>

<?php include "header.php"?>
<?php include "navbar_connected.php"?>
<button id="btnVideo" class='m-2' onclick="playAndPause()">II</button>
   
<div class='vh-75 p-5   m-5'>
    <div class="box w-100 h-auto">

            <p>Bonjour, <br> Vous vous êtes inscrits au casting de the Voice.<br>Cependant il reste encore quelques étapes afin de finaliser votre inscription  et ainsi pouvoir participer au casting.<br>
                Dans un premier temps vous devez vous rendre dans l'onglet "Mon Profil" pour y selectionner la musique que vous souhaitez interpreter. <br>
                Notre super katie validera ainsi votre musique , vous permettants d'upload votre bande son. Aprés que celle ci est etais accepté par la super Katie 
                nous vous demanderons un chéques. <br>A la reception de ce paiement vous recevrez une facture ainsi qu'une convocation pour votre prestation.
                <br> L'équipe The Voice  
            </p>
    </div>
</div>
<video id="background-video" src="Images/Generique.mp4" type="video/mp4" autoplay  ></video>    

</body>
    

    