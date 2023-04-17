<?php
session_start();
if(!$_SESSION["user"]){
    header("location: index.php");
    exit;
}
$title = "Accueil"; ?>

<?php include "header.php";?>
<body class="profil_body">
<?php require "navbar_connected.php";?>
<h2 class="text-center mt-5 text-white">Bienvenue sur ton profil</h2> <br>
<div class='d-flex justify-content-center'>
<img    src="Images/undraw_male_avatar_re_y880.svg" width="150px" alt="">
</div>
<form  class='d-flex m-auto flex-column text-center'>
<label class="form-label " for="nom">Nom</label>
<input style='color:black' class="form-control w-auto " disabled type="text" name="nom" value="<?= $_SESSION["user"]["nom"] ?>">

<label class="form-label" for="prenom">Prénom</label>
<input style='color:black'class="form-control w-auto" disabled type="text" name="prenom" value="<?= $_SESSION["user"]["prenom"] ?>"> 

<label class="form-label" for="email">E-mail</label>
<input style='color:black'class="form-control w-auto" disabled type="text" name="email" value=" <?= $_SESSION["user"]["email"] ?>">

<label class="form-label" for="age">Age</label>
<input style='color:black' class="form-control w-auto"  disabled type="text" name="age" value="<?= $_SESSION['user']['age'] ?> ans" >

</form>
 <section class="step-wizard">
        <ul class="step-wizard-list">
            <li class=" <?php if($_SESSION["user"]["statutChoixChanson"] === 0){ echo 'step-wizard-item current-item';}else{ echo 'step-wizard-item';}?>">
                <span class="progress-count">1</span>
                <span class="progress-label">Choix chanson</span>
            </li>
            <li class=" <?php if($_SESSION["user"]["statutEnvoiChanson"] === 0){ echo 'step-wizard-item current-item';}else{ echo 'step-wizard-item';}?>">
                <span class="progress-count">2</span>
                <span class="progress-label">Envoie chanson</span>
            </li>
            <li class=" <?php if($_SESSION["user"]["statutPaiement"] === 0){ echo 'step-wizard-item current-item';}else{ echo 'step-wizard-item';}?>">
                <span class="progress-count">3</span>
                <span class="progress-label">Paiement</span>
            </li>
            <li class="step-wizard-item">
                <span class="progress-count">4</span>
                <span class="progress-label">Inscription réalisée</span>
            </li>
        </ul>
    </section>

  
    
      
</body>
</html>