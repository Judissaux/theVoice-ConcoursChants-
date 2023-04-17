<?php  session_start(); ?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include "header.php";?>
    <link rel="stylesheet" href="recap_page.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class="envoi_bg">
<?php include "navbar_connected.php";?>
<h1 class=" bg-light bg-opacity-75 text-center pt-5 pb-5   text-bold  text-danger mb-4">Bravo <?php echo $_SESSION['user']['prenom'];?> , vous avez finaliser votre inscription , vous trouverez ci-joint un récapitulatif :</h1>
<div class="carre">
    <section class=" carre_interieur  mt-5">
    <div class="center">
    <?php  
    $int = time() + 825626 ;
    setlocale(LC_TIME, 'fr_FR.utf8');
    $date = strftime("%e %B %Y, 14h00", $int);
       echo'
    <p class="mb-5"> Vous êtes prié de  vous présenter le<br> <strong>  '.$date.'</strong> </p><br><h3 class="text-dark mb-5"> Téléchargez votre facture :</h3>';
       ?>
      <a class="trigger" href="composer/facture.php">
        <span>
          <em>Facture</em>
          <i aria-hidden="true"></i>
        </span>
      </a>
    </div>
</div>
</body>
</html>