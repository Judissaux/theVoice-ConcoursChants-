<?php
session_start();
if(!$_SESSION["user"]){
    header("location: index.php");
    exit;
}

unset($_SESSION["user"]);
header("location: index.php");