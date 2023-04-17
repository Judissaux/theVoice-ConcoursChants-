<?php session_start() ?>
<nav class="navbar navbar-expand navbar-dark bg-dark">
<div class="container-fluid">
  <div class="  d-flex justify-content-between collapse navbar-collapse" id="navbarresponsive">
         <a href="#" class="navbar-brand"><img class="logo" src="Images/logo.png"></a>
  <div class='p-2'>
    <?php  require "connexion.php"?>
      <button class=" btn btn-success mx-3  btn-outline-danger mr-2 text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">Connexion</button>
    <?php  require "inscription.php";?>
      <button class="btn btn-primary  btn-outline-warning  text-white" data-bs-toggle="modal" data-bs-target="#exampleModalu">Inscription</button>       
    </div>
  </div>            
</div>
</nav>
     