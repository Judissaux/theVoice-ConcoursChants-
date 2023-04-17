<?php 
session_start();
if ($_SESSION["user"]) {
  header("location: accueil_connect.php");
  exit;
}
$_SESSION["error"] = [];
if (!empty($_POST && isset($_POST["connexion"]))) {

  if (isset($_POST["email_connexion"], $_POST["mdp_connexion"],$_POST["connexion"]) && !empty($_POST["email_connexion"]) && !empty($_POST["mdp_connexion"])) {      
  
    // Vérification si c'est bien un email
    if (!filter_var($_POST["email_connexion"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"][] = "Adresse email ou mot de passe incorrect";
    }      

    require "conectbdd.php";
    $requete = $connexion->prepare("SELECT * FROM `user` WHERE email = :email");
    $requete->bindParam(":email",$_POST["email_connexion"]);
    $requete-> execute();
    $user = $requete->fetch();
     
    if (!$user) {
        $_SESSION["error"][] = "Utilisateur ou mot de passe incorrect";
    }
    elseif(!password_verify($_POST["mdp_connexion"], $user["password"])) {
        $_SESSION["error"][] = "Utilisateur ou mot de passe incorrect";        
    }         
    if ($_SESSION["error"] === []){
        if($user["type"] === "admin"){
          header("location: admin.php");
          $_SESSION["user"] = [
              "id" => $user["id"],
              "nom"=> $user['nom'],
              "prenom" => $user['prenom'],
              "type" => $user["type"]
              ];
            }
      elseif($user["type"] === "user"){
        $_SESSION["user"] = [
            "id" => $user["id"],
            "nom"=> $user['nom'],
            "prenom" => $user['prenom'],
            "email" => $user['email'],
            "age"=>$user['age'],
            "sexe"=>$user['sexe'],
            "type" => $user["type"],
            "statutChoixChanson" => $user["statutChoixChanson"],
            "statutEnvoiChanson" => $user["statutEnvoiChanson"],
            "statutPaiement" => $user["statutPaiement"],
            ];
           header("location: accueil_connect.php");
            
        }
      }
    }else{
          $_SESSION["error"] = ["Tous les champs ne sont pas remplies"];
         }
  }

?>

 <!-- Modal  connexion -->
 <div class="modal fade" id="exampleModal" >
    <div class="modal-dialog modal-dialog-centered   ">
      <div class="modal-content">
        <div class="modal-body ">
          <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" ></button>
        <div class="   opacity-75  bg-dark  justify-content-center text center"> 
<!-- début du form-->
<form  method="POST" class="myform m-auto d-flex flex-column" >

<h5 class="text-center text-white">Connexion</h5>
  <?php  if (isset ($_SESSION['error'],$_POST["connexion"])){
      foreach ($_SESSION['error'] as $message_erreur ){
              echo $message_erreur;
            }
        unset($_SESSION['error']);
      } 
  ?>
  <div class=" px-3 text-center m-auto">
      <div class=" d-flex flex-column text-center ">
          <label for="name" >Email</label>
          <input type="text"  class="form-control  text-center " name="email_connexion" >
      </div>
      <div class=" px-3 text-center m-auto">
      <div class=" d-flex flex-column text-center ">
          <label for="name" >Mot de passe</label>
          <input type="password"  class="form-control  text-center " name="mdp_connexion" >
      </div>
      <button type="submit" class="btn btn-danger mt-3" name="connexion">Connexion</button> 
         
</form>
          </div>
      </div>
    </div>
  </div>
</div>
  <!-- fin  Boutton connexion modal-->
  </div>
  </div>
</body>
</html>
