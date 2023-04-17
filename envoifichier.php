<?php
session_start();
if(!$_SESSION["user"]){
    header("location: index.php");
    exit;
}
$title = "Envoiechanson";
// !empty($_post) permet de pouvoir lancer la page sinon cela afficherai une erreur


$iduser = $_SESSION["user"]["id"];
require_once "conectbdd.php";
$req = $connexion->prepare("SELECT `statutChoixChanson`,`statutEnvoiChanson`,`envoiSupprime` FROM `user` WHERE id=$iduser");
$req->execute();
$infos = $req->fetch();

if($infos["statutChoixChanson"]=== 1 && $infos["statutEnvoiChanson"]=== 0){
 if(!empty($_POST)){
    if (isset($_FILES["fichier"], $_POST["nom"]) && $_FILES["fichier"]["error"] === 0 && !empty($_FILES["fichier"]) && !empty($_POST["nom"])) {
        
        // On protége le nom envoyé
        $newname = strtolower(strip_tags($_POST["nom"]));
        $newnamenettoye = str_replace(' ', '-', $newname);
        
        // on a reçu le fichier
        // on procéde aux vérifications
        // on vérifie toujours l'extension et le type MIME
        $allowed = [
            "mp3" => "audio/mpeg",
        ];

        $filename = $_FILES["fichier"]["name"];
        $filetype = $_FILES["fichier"]["type"];
        $filesize = $_FILES["fichier"]["size"];

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        // on vérifie l'absence de l'extension dans la ou les clés de $allowed ou l'absence du type MIME
        // la fonction array_key_exists vérifie si la clés mp3 existe dans le fichier extension
        // in_array vérifie si le type et présent dans le tableau allowed
        if (!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed))
            // ici soit l'extension soit le type est incorrect ou les deux
            die("Le fichier sélectionné n'est pas au bon format !");
        
        //on génére le chemin complet
        $newfilename = "archivage/$newnamenettoye.$extension";
        if (!move_uploaded_file($_FILES["fichier"]["tmp_name"],$newfilename)) {
            die("L'upload a échoué");
        }
        // premier chiffre aprés le zéro "le propiétaire",le deuxième chiffre c'est le groupe,le troisième chiffre c'est "le visiteur" , 0644 c'est 6 lecture ecriture et 4 lecture seulement
        chmod($newfilename, 0644);
        require "conectbdd.php";
        $sql = "UPDATE`choixMusique` SET `ChansonEnvoyée` = :url  WHERE `id_user` = $iduser";
        $requete = $connexion->prepare($sql);
        $requete->bindValue(":url", $newfilename);
        $requete->execute();

        $req = $connexion->prepare("UPDATE `user` SET `envoiSupprime` = 0 WHERE id = $iduser");
        $req->execute();

    }else{
    die("Les champs ne sont pas correctement remplies!");
    }

 }
    
}else if($infos["statutChoixChanson"]=== 1 && $infos["statutEnvoiChanson"]=== 1){
    header("location: accueil_connect.php");
}else{
    header("location: choixChanson.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "header.php";?>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js" defer></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<title></title>
</head>

<body class="envoi_bg">
<?php require "navbar_connected.php";

$req = $connexion->prepare("SELECT `ChansonEnvoyée` FROM `choixMusique`  WHERE id_user = $iduser");
$req->execute();
$result = $req->fetch();
$info = $result["ChansonEnvoyée"];

if($info != 'NULL'){
    echo "<h3 class='text-center text-white mt-5'> Votre chanson a bien été transmise, l'administrateur va la controler et vous pourrez passer à l'étape suivante si votre chanson est conforme</h3>";
   
}elseif($infos["envoiSupprime"] === 1){ ?>
<div class="w-100  d-flex flex-column align-items-center ntm">
    <h1 class="text-danger font-weight-bold text-center mt-5 d-flex align-items-center">Votre chanson ne correspond pas à nos attentes ou elle a déjà été sélectionnée</h1>
    

   <form class="row g-3 py-5 align-items-center d-flex  flex-column m-auto w-100" action="#" method="post"  enctype="multipart/form-data">

<div class="input-group mb-3 w-25">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon3">Nom fichier</span>
  </div>
  <input class="form-control" type="text" name="nom" id="nom basic-url" aria-describedby="basic-addon3"> 
</div>

<div class="mb-3 w-25 text-center">
  <label for="fichier" class="form-label text-center  text-white">Veuillez upload votre bande son</label>
  <input class="form-control text-left"  type="file" name="fichier" id="fichier" accept="audio/mp3">
</div>
<button class="col-auto btn btn-primary" name="submit" type="submit">Valider</button>
    </form> 
</div>
    </form>

  <?php }else{ ?>
    <!-- <form class="row g-3 py-5" action="#" method="post"  enctype="multipart/form-data">

<div class="col-auto ">
    <label class="form-label  " for="nom">Nom du fichier</label>
    <input class="form-control" type="text" name="nom" id="nom">
</div>
<div class="col-auto">
    <input class="form-control" type="file" name="fichier" id="fichier" accept="audio/mp3">
</div>
<button class="col-auto btn btn-primary" name="submit" type="submit">Valider</button>
</form> -->
<div class="w-100  d-flex flex-column align-items-center ntm">
   
    

   <form class="row g-3 py-5 align-items-center d-flex  flex-column m-auto w-100" action="#" method="post"  enctype="multipart/form-data">

<div class="input-group mb-3 w-25">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon3">Nom fichier</span>
  </div>
  <input class="form-control" type="text" name="nom" id="nom basic-url" aria-describedby="basic-addon3"> 
</div>

<div class="mb-3 w-25 text-center">
  <label for="fichier" class="form-label text-center  text-white">Veuillez upload votre bande son</label>
  <input class="form-control text-left"  type="file" name="fichier" id="fichier" accept="audio/mp3">
</div>
<button class="col-auto btn btn-primary" name="submit" type="submit">Valider</button>
</form> 
</div>
    </form>
<?php } ?>
</body>
</html>