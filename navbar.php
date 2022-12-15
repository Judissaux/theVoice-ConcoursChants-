<?php session_start() ?>
 <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
        <div class="container-fluid">
            <a href="#" class="navbar-brand"><img class="logo" src="Images/logo.png"></a>
          <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarresponsive" aria-controls="navbarresponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon text-white"></span>
          </button>
          <div class="  d-flex flex-row-reverse collapse navbar-collapse" id="navbarresponsive">
            <?php  require "connexion.php";?>
            <button class=" btn btn-success mx-3  btn-outline-danger mr-2 text-white" data-bs-toggle="modal" data-bs-target="#exampleModal">Connexion</button>
            <?php  require "inscription.php";?>
            <button class="btn btn-primary  btn-outline-warning  text-white" data-bs-toggle="modal" data-bs-target="#exampleModalu">Inscription</button>
          </div>
        </div>
      </nav>

</nav>
