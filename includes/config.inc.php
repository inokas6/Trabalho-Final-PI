<?php
    global $arrConfig;
    error_reporting(E_ALL);
    ini_set('display_errors', 1); 
    @session_start();


    include 'db.inc.php';
    include 'functions.inc.php';
    include 'admin.inc.php';

   $arrConfig['url'] = 'http://localhost/TrabalhoFinal-PI/';

   

   $num_por_pag = 15;
   $max_slides = 4;
   $max_produtos_destacados = 3;


   if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['ling'])){
    $_SESSION['ling'] = $_GET['ling'];
    header('Location: ' . $_SESSION['pag']);
   }elseif(!isset($_SESSION['ling'])){ //Caso seja a primeira vez
        $_SESSION['ling'] = 'pt';
   }

   $_SESSION['pag'] = $_SERVER['PHP_SELF']; //Salva a ultima pagina