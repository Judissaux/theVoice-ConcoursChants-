<?php
$title = "Administration";
session_start();
if(!$_SESSION["user"] || $_SESSION["user"]["type"] !== "admin"){
    header("location: index.php");
}

require_once "conectbdd.php";

// Partie pour valider les actions
if(isset($_GET["confirmeChoix"]) && !empty($_GET["confirmeChoix"])){
    $confirmeChoix = (int) $_GET['confirmeChoix'];
    $req = $connexion->prepare("UPDATE `user` SET statutChoixChanson = '1' WHERE id = ?");
    $req->execute(array($confirmeChoix));

}else if(isset($_GET["confirmeEnvoi"]) && !empty($_GET["confirmeEnvoi"])){
    $confirmeEnvoi = (int) $_GET['confirmeEnvoi'];
    $req = $connexion->prepare("UPDATE `user` SET statutEnvoiChanson = '1' WHERE id = ?");
    $req->execute(array($confirmeEnvoi));

}else if(isset($_GET["confirmePaiement"]) && !empty($_GET["confirmePaiement"])){
    $confirmePaiement = (int) $_GET['confirmePaiement'];
    $req = $connexion->prepare("UPDATE `user` SET statutPaiement = '1' WHERE id = ?");
    $req->execute(array($confirmePaiement));
}


// Partie pour annuler les actions
if(isset($_GET["annuleChoix"]) && !empty($_GET["annuleChoix"])){
    $annuleChoix = (int) $_GET['annuleChoix'];
    $req = $connexion->prepare("UPDATE `user` SET statutChoixChanson = '0' WHERE id = ?");
    $req->execute(array($annuleChoix));
}else if(isset($_GET["annuleEnvoi"]) && !empty($_GET["annuleEnvoi"])){
    $annuleEnvoi = (int) $_GET['annuleEnvoi'];
    $req = $connexion->prepare("UPDATE `user` SET statutEnvoiChanson = '0' WHERE id = ?");
    $req->execute(array($annuleEnvoi));
}else if(isset($_GET["annulePaiement"]) && !empty($_GET["annulePaiement"])){
    $annulePaiement= (int) $_GET['annulePaiement'];
    $req = $connexion->prepare("UPDATE `user` SET statutPaiement = '0' WHERE id = ?");
    $req->execute(array($annulePaiement));
}

// partie pour supprimer le choix de la chanson  
if(isset($_GET["supprimeChoix"]) && !empty($_GET["supprimeChoix"])){
    $supprimeChoix = (int) $_GET['supprimeChoix'];
    $req = $connexion->prepare("DELETE FROM `choixMusique` WHERE id_user = ?");
    $req->execute(array($supprimeChoix));
    
// partie pour supprimer la bande sonore envoyé (à la fois dans la bdd et aussi dans le fichier archivage)
}else if(isset($_GET["supprimeEnvoi"]) && !empty($_GET["supprimeEnvoi"])){
    $supprimeEnvoi = (int) $_GET['supprimeEnvoi'];

// PARTIE POUR SUPPRIMER LE FICHIER DANS LE REPERTOIRE ARCHIVAGE
    $query = $connexion->prepare("SELECT `chansonEnvoyée` FROM `choixMusique` WHERE id_user= ?");
    $query->execute(array($supprimeEnvoi));
    $result = $query->fetch();
    $CheminFichier = $result["chansonEnvoyée"];
    if (file_exists($CheminFichier)) {
				if (!unlink($CheminFichier)){echo "Problème lors de l'effacement de $CheminFichier<br />\n";}
				else {echo "Fichier $CheminFichier effacé.<br />\n";}
			}
			else {echo "Le fichier $CheminFichier n'a pas été trouvé.<br />\n";}

// PARTIE POUR UPDATE LE CHEMIN DE CHANSON ENVOYEE
    $req = $connexion->prepare("UPDATE `choixMusique` SET `chansonEnvoyée` = 'NULL' WHERE id_user = ?");
    $req->execute(array($supprimeEnvoi));}

// partie pour udpate donnée choix supprimé
if(isset($_GET["supprimeChoix"]) && !empty($_GET["supprimeChoix"])){
    $supprimeChoix = (int) $_GET['supprimeChoix'];
    $req = $connexion->prepare("UPDATE `user` SET `choixSupprime` = 1, `statutChoixChanson` = 0 WHERE id = ?");
    $req->execute(array($supprimeChoix));

// partie pour udpate donnée envoi supprimé
}else if(isset($_GET["supprimeEnvoi"]) && !empty($_GET["supprimeEnvoi"])){
    $supprimeEnvoi = (int) $_GET['supprimeEnvoi'];
    $req = $connexion->prepare("UPDATE `user` SET `envoiSupprime` = 1 WHERE id = ?");
    $req->execute(array($supprimeEnvoi));			
}

?>
<?php require_once "header.php"; ?>
<body  class="bgAdmin">
<?php require_once "navbar_connected.php" ?>

<h2 class="text-center my-4 text-white">Table des inscrits</h2>

    <table class="table table-dark table-bordered table-hover" style="text-align:center">
        <thead class="thead-dark">
            <tr class="text-align-center">
                <th>ID</th>
                <th>Prenom</th>
                <th>Nom</th>
                <th>Email utilisateur</th>
                <th>Type</th>
                <th>Statut choix chanson</th>
                <th>Choix Supprimé</th>
                <th>Statut Envoi chanson</th>
                <th>Envoi Supprimé</th>
                <th>Statut Paiement</th>                                  
            </tr>
        </thead>
        <tbody>
         
         <!-- PARTIE QUI REGROUPE TOUTES LES INFOS DES MEMBRES INSCRITS SAUF LE MDP -->
        <?php 
            $requete = $connexion->query("SELECT id,`nom`, `prenom`, `email`,`statutChoixChanson`,`choixSupprime`,`statutEnvoiChanson`,`envoiSupprime`,`statutPaiement`,`type` FROM `user` ");
            while ($data = $requete->fetch()) {
                if($data['statutChoixChanson']===1 && $data['statutEnvoiChanson']===1 && $data['statutPaiement']===1){ echo "<tr class='table-success'>";}
                else{ "<tr>";}
                echo "<td>" . $data['id'] . "</td>";
                echo "<td>" . $data["prenom"] . "</td>";
                echo "<td>" . $data["nom"] . "</td>";
                echo "<td>" . $data["email"] . "</td>";
                echo "<td>" . $data["type"] . "</td>";
               if($data['statutChoixChanson']===1){ echo "<td class='text-success h5'>" . $data['statutChoixChanson'] . "</td>";}else{echo "<td>" . $data['statutChoixChanson'] . "</td>";}
               if($data['choixSupprime']===1){ echo "<td class='text-danger h5'>" . $data['choixSupprime'] . "</td>";}else{echo "<td>" . $data['choixSupprime'] . "</td>";}
                if($data['statutEnvoiChanson']===1){ echo "<td class='text-success h5'>" . $data['statutEnvoiChanson'] . "</td>";}else{echo "<td>" . $data['statutEnvoiChanson'] . "</td>";}
                if($data['envoiSupprime']===1){ echo "<td class='text-danger h5'>" . $data['envoiSupprime'] . "</td>";}else{echo "<td>" . $data['envoiSupprime'] . "</td>";}
                if($data['statutPaiement']===1){ echo "<td class='text-success h5'>" . $data['statutPaiement'] . "</td>";}else{echo "<td>" . $data['statutPaiement'] . "</td>";}
                echo "</tr>";
             };
        ?>
        </tbody>
    </table>
   

    <h2 class="text-center my-4 text-white">Table des participants</h2>
    
    <table class="table table-dark table-bordered table-hover "  style="text-align:center; vertical-align:middle" >
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Email utilisateur</th>
                <th>Choix de la chanson</th>
                <th>validation choix de la chanson</th>                
                <th>Fichier envoyé</th>   
                <th>Validation envoi de la chanson</th>  
                <th>Validation Paiement</th>                  
            </tr>
        </thead>
    

        <tbody  >

 <!-- PARTIE QUI REGROUPE TOUTES LES INFOS DES MEMBRES PARTICIPANTS AU CONCOURS ET QUI PERMET DE VALIDER LES DIFFERENTES ETAPES -->

        <?php 

            $requete = $connexion->query("SELECT user.id,email,statutChoixChanson,statutEnvoiChanson,statutPaiement,artiste,titre,img,chansonEnvoyée FROM `user` INNER JOIN `choixMusique` ON user.id = choixMusique.id_user");
           
            while ($data = $requete->fetch()) {
                
               
                echo "<tr>";
                
                echo "<td style='padding-top:20px'>" . $data['id'] . "</td>";
                echo "<td style='padding-top:20px'>" . $data["email"] . "</td>";

                // Partie pour valider ou pour supprimer le choix du participant en cas de non-conformité ou erreur
                 echo // Button trigger modal
                '<td style="padding-top:20px"> <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal'.$data['id'].'">
                '.$data["artiste"].'
                </button>              
                        <div class="modal fade" id="exampleModal'.$data['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <button style="margin: 10px 0px 0px 350px " type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                      <div class="modal-header">
                        <img style="width:300px; margin-left :35px;border-radius:10px;" src=' .$data["img"].'>
                      </div>
                
                      <div class="modal-body">
                      <h5 style="text-align:center; padding:0; color:black" class="modal-title" id="exampleModalLabel">' .$data["artiste"].' </h5>
                      <p style="padding:0">'.$data["titre"] .'</p>
                      </div>';
                if($data["statutChoixChanson"] === 0){ 
                    echo '<div class="modal-footer" style="margin-right: 90px;">
                        <a class="btn btn-success" href="admin.php?confirmeChoix='. $data['id'] .'" >Valider</a>
                        <a class="btn btn-danger" href="admin.php?supprimeChoix=' .$data['id'] .'">Supprimer</a>
                        </div>
                    </div>
                  </div>
                </div> </td>';}
                
            if($data['statutChoixChanson'] === 0){
                echo "<td style='padding-top:20px'> Attente validation choix de la chanson </td> ";
             }
                // Si le choix est validé on affiche le message 'Choix de la chanson validé' avec une possibilité d'annulé en cas d'erreur
            else if($data['statutChoixChanson'] === 1){
                echo "<td style='padding-top:20px' class='text-success'>Choix de la chanson validé <br> <a class='btn-outline-warning btn-sm ' href='admin.php?annuleChoix=". $data['id'] ."' >Annuler?</a></td>";
                        } 
                
                // Partie pour supprimer la chanson envoyée par le participant en cas de non-conformité ou erreur
                echo "<td><audio controls='controls'> <source src=". $data["chansonEnvoyée"] . "></audio> <br>";
                 "</td>";    
                // on vérifie si le statut le paiement de l'inscription n'est pas déjà différent de 1 ,que le choix de la chanson est validé (1) et que l'envoi est validé (1)
                 
                // on vérifie si le statut pour l'envoi de la chanson n'est pas déjà différent de 1 et que le choix de la chanson est validé (1)
                 if($data['statutEnvoiChanson'] === 0 && $data['statutChoixChanson'] === 1 ){
                    echo "<td style='padding-top:20px'> <a  class='btn btn-success btn-sm mx-2' href='admin.php?confirmeEnvoi=". $data['id'] ."' >Valider choix </a>";
                        if($data['chansonEnvoyée'] !== 'NULL'){ echo "<a  class='btn btn-danger btn-sm mx-2' href='admin.php?supprimeEnvoi=" .$data['id'] . "'>Supprimer</a> </td>";}
   
                           // si le choix de la chanson n'a pas encore été validé on affiche le message 'Attente validation choix de la chanson'
                   }else if($data['statutChoixChanson'] === 0){ 
                    echo "<td style='padding-top:20px'> Attente validation étape précédente </td>";
   
                       // si le choix de la chanson et l'envoi est validé on affiche le message 'Chanson receptionnée et validé' avec une possibilité d'annulé en cas d'erreur
                    }else{
                    echo "<td style='padding-top:20px' class='text-success'>Chanson réceptionné et validé<br> <a class='btn-outline-warning btn-sm' href='admin.php?annuleEnvoi=". $data['id'] ."'>Annuler?</a></td>";         
                      }
                    ;
                    
   
                if($data['statutEnvoiChanson'] === 1 && $data['statutChoixChanson'] === 1  && $data['statutPaiement'] === 0){
                    echo "<td style='padding-top:20px'> <a class='btn btn-success' href='admin.php?confirmePaiement=". $data['id'] ."' >Valider choix </a></td>";

                   // si le choix de la chanson ou l'envoi de la chanson n'est pas validé on affiche le message ' Attente validation choix de la chanson et/ou envoi de la chanson'
                }else if($data['statutChoixChanson'] === 0 ||  $data['statutEnvoiChanson'] === 0){ 
                echo "<td style='padding-top:20px'> Attente validation étape précédente </td>";

                // si le paiement est validé on affiche  'Paiement effectué et validé' avec une possibilité d'annulé en cas d'erreur
                }else{ echo "<td style='padding-top:20px' class='text-success'>Paiement effectué et validé<br> <a class='btn-outline-warning btn-sm' href='admin.php?annulePaiement=". $data['id'] ."' >Annuler?</a></td>";         
                     }
                     
                echo "</tr>";
               
            }
        ?>
       
        </tbody> 
        
          </table>
        
</body>
</html>