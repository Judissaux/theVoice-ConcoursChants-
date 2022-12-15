<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="#" class="navbar-brand"><img class="logo" src="Images/logo.png"></a>
          <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarresponsive" aria-controls="navbarresponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-white"></span>
          </button>
          <?php if($_SESSION["user"]["type"] === 'user'){ ?>
          <div class="collapse navbar-collapse " id="navbarresponsive">            
            <ul class="navbar-nav m-auto me-auto mb-2 mb-lg-0">
                <li class="nav-item ml-5">
                  <a class="nav-link  text-white"  href="accueil_connect.php">Accueil</a>
                </li>
                <?php if($_SESSION["user"]["statutChoixChanson"]=== 0){echo 
                '<li class="nav-item ml-5">
                  <a class="nav-link text-white" href="choixChanson.php">Choix de la chanson</a>
                </li>';
              }?>
                <?php if($_SESSION["user"]["statutChoixChanson"]=== 1 &&  $_SESSION["user"]["statutEnvoiChanson"]=== 0 ){echo 
                '<li class="nav-item ml-5">
                  <a class="nav-link text-white" href="envoifichier.php" >Envoi du fichier</a>
                </li>';
              }?>
              <?php if($_SESSION["user"]["statutChoixChanson"]=== 1 &&  $_SESSION["user"]["statutEnvoiChanson"]=== 1 && $_SESSION["user"]["statutPaiement"] === 0){echo 
                '<li class="nav-item ml-5">
                  <a class="nav-link text-white" href="paiement.php" >Paiement </a>
                </li>';
              }?>
              <?php if($_SESSION["user"]["statutChoixChanson"]=== 1 &&  $_SESSION["user"]["statutEnvoiChanson"]=== 1 && $_SESSION["user"]["statutPaiement"] === 1){echo 
                '<li class="nav-item ml-5">
                  <a class="nav-link text-white" href="recap.php" >Récapitulatif</a>
                </li>';
              }?>

                <li class="nav-item ml-5">
                  <a class="nav-link text-white" href="Profil.php" >Profil </a>
                </li>
              </ul>
              <?php }
              else{ echo "<h1 class='text-center my-3 text-white' >Bienvenue sur ton panneau d'administration". " ". $_SESSION["user"]["prenom"] . "</h1>
              ";} ?> 
              
              <a href="deconnexion.php" class="btn btn-primary  btn-outline-warning  text-white">Deconnexion</a>
             </div>
        </div>
      </nav>

