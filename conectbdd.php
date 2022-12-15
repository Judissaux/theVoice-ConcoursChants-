<?php 
$bdd_name = 'mysql:host=localhost;dbname=thevoice';
$user = 'justinD';
$pass = 'chajuoli';
try {
    $connexion = new PDO(
        $bdd_name, 
        $user, 
        $pass
    );
    $connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} 
catch (PDOException $excep)
{
    echo "erreur connexion" . $excep->getMessage();
}
?>
