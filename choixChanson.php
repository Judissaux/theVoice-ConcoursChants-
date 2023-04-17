<?php
$title = "ChoixChanson";
session_start();
if(!$_SESSION["user"]){
    header("location: index.php");
    exit;
}

 // récupération id de l'utilisateur
 $iduser = $_SESSION["user"]["id"];

require_once "conectbdd.php";

if(!empty($_GET)){
    if(isset($_GET["artiste"],$_GET["titre"],$_GET["img"]) && !empty($_GET["artiste"]) && !empty($_GET["titre"]) && !empty($_GET["img"])){
        // insertion du nom de l'artiste
        $artiste = ucfirst(strip_tags(strtolower($_GET["artiste"])));
       // insertion du titre de la chanson
        $titre = ucfirst(strip_tags(strtolower($_GET["titre"])));
                
        // Vérif si chanson déjà envoyé
       
        $req = $connexion->prepare("SELECT `img` FROM `choixMusique` WHERE id_user = $iduser");
        $req->execute();
        $musiquePresente = $req->fetch();
        if($musiquePresente){
            die("Chanson déjà selectionné, veuillez attendre que l'admin valide votre choix");
        } 
            
        $sql = "INSERT INTO `choixMusique` (`id_user`,`artiste`,`titre`,`img`,`extrait`,`chansonEnvoyée`) VALUES( $iduser ,:artiste,:titre,:img,:extrait,'NULL') ";
        $requete = $connexion->prepare($sql);
        $requete->bindValue(":artiste",$artiste,PDO::PARAM_STR);
        $requete->bindValue(":titre",$titre,PDO::PARAM_STR);
        $requete->bindValue(":img",$_GET["img"]);
        $requete->bindValue(":extrait",$_GET["extrait"]);
        $requete->execute();
        
        $req = $connexion->prepare("UPDATE `user` SET `choixSupprime` = 0  WHERE id = $iduser");
        $req->execute();
        
    }else{
        echo "Erreur, veuillez selectionner une chanson";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
      
    <?php include "header.php";?>
    <title>CHoixChanson</title>
</head>
<body class="bg-grey">
   
<?php require "navbar_connected.php";?>
    <h1 class="text-center mt-5 mb-5">Bonjour <?= $_SESSION["user"]["prenom"] ?> </h1>
  


<?php 

$req = $connexion->prepare("SELECT `choixSupprime`,`statutChoixChanson`FROM `user` WHERE id = $iduser");
$req->execute();
$etatChoix = $req->fetch();


$req = $connexion->prepare("SELECT `img` FROM `choixMusique` WHERE id_user = $iduser");
$req->execute();
$musiquePresente = $req->fetch();

if($musiquePresente["img"] !==NULL && $etatChoix["statutChoixChanson"] === 0){ ?>
<h3 class="text-center mt-5">Votre musique est en cours de validation ...</h3>
<p class="text-center mt-5" >Un admin va étudier votre demande, revenez ultérieurement pour vérifier son avancée .</p>

<?php }else if($etatChoix["statutChoixChanson"] === 1 && $musiquePresente != NULL ){?>
    
<h3 class="text-center mt-5">Félicitation votre chanson a été validé</h3>
<p class="text-center mt-5">Cliquer sur ce <a href="envoifichier.php">lien</a> pour nous envoyé votre bande son  et continuer votre processus d'inscription ! </p>

<?php } ?>    

<?php
if($etatChoix["choixSupprime"] === 1 && !$musiquePresente){ ?>

    <h3 class="text-center text-danger">Votre chanson n'a pas été validé, veuillez en selectionner une autre. </h3>
  
    <form method="POST" action="#" class="text-center d-flex flex-column m-auto w-25 myform" ">
        
        <label for="artiste" class="text-dark">Artiste</label>
        <input type="text" name="artiste" id="artiste" class=" border-dark text-dark form-control m-auto">
        <label for="titre" class="text-dark">Titre</label>
        <input type="text" name="titre" id="titre"  class="form-control border-dark m-auto text-dark ">
        <div class="text-center"><button class=" mt-5 mb-5 button-30">Confirmer</button></div>

    </form>  
     
<?php }else if($etatChoix["choixSupprime"] === 0 && !$musiquePresente){ ?>

<h3 class="text-center">Choisi la chanson que tu souhaites chanter ! </h3>

<form method="POST" action="#" class="text-center d-flex flex-column m-auto w-25 myform">
            
    <label for="artiste" class="text-dark">Artiste</label>
    <input type="text" name="artiste" id="artiste" class=" border-dark text-dark form-control m-auto">
    <label for="titre" class="text-dark">Titre</label>
    <input type="text" name="titre" id="titre"  class="border-dark form-control m-auto text-dark ">
    <div class="text-center"><button class=" mt-5 mb-5 button-30">Confirmer</button></div>

</form>  

 <?php } ?>

<?php 
// API
$url = "https://shazam.p.rapidapi.com/search?term=".str_replace(' ', '%20',$_POST['titre'])."%20".str_replace(' ', '%20',$_POST['artiste'])."&locale=fr-FR&offset=0&limit=4";
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: shazam.p.rapidapi.com",
        "X-RapidAPI-Key: ef11b74c10mshdea2f57290141fap18aa47jsnc26bba0b5854"
    ],
]);

$response = curl_exec($curl);

$parsee=json_decode(curl_exec($curl), true);
$data = $parsee["tracks"]["hits"];
foreach($data as $dat){
    $artiste = $dat["track"]["subtitle"];
    $titre = $dat["track"]["title"];
    $img = $dat["track"]["share"]["image"];
    $extrait = $dat["track"]["hub"]["actions"]["1"]["uri"];
   
    echo "<div class='d-flex flex-lg-row   flex-column mx-md-5  justify-content-center '> 
   
    <div class='cardProjets d-flex'>
        <div class='card text-center m-auto text-center '>
            <div class='d-flex'><img src='$img'  style='width:250px' class=' mt-2  m-auto d-flex justify-content-center'></div>
            <div class='text'>
            <h5  name ='artiste' class='card-title text-dark mt-3 '>$artiste <br> <strong> $titre </strong></h5>
            <div class='text-center mt-2'> <audio controls='controls' class=' w-100 text-center'> <source src='$extrait'></audio> </div>
            <div class='text-center mt-2'>  <a href='choixChanson.php?img=".$img."&titre=".$titre."&artiste=".$artiste."&extrait=".$extrait."' class='bouncy btn btn-primary btn-outline-warning text-white w-50 '> <strong>VALIDER</strong></a></div>
            </div>       
        </div>
    </div>";      
}
$err = curl_error($curl);
curl_close($curl);
?>
</body> 
</html>
 
