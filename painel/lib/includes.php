<?php
    session_start();

    // include("connect_local.php");

    include("/cheapinc/connect.php");
    $con = AppConnect('app');

    // include("/appinc/connect.php");
    include("fn.php");

    $md5 = md5(date("YmdHis"));


    // $_SESSION = [];

     if($_POST['historico']){
         $pagina = str_replace("/app/", false, $_SERVER["PHP_SELF"]);
         $destino = $_POST['historico'];
         $i = ((count($_SESSION['historico']))?(count($_SESSION['historico']) -1):0);
         if($_SESSION['historico'][$i]['local'] != $pagina){
             $j = (($_SESSION['historico'][$i]['local'])?($i+1):0);
             $_SESSION['historico'][$j]['local'] = $pagina;
             $_SESSION['historico'][$j]['destino'] = $_POST['historico'];
             unset($_POST['historico']);
             $_SESSION['historico'][$j]['dados'] = json_encode($_POST);
         }else{
             unset($_POST['historico']);
         }
     }

    include("dicionary_".(($_SESSION['lng'])?$_SESSION['lng']:'en').".php");

    $localPainel = $_SERVER["REQUEST_SCHEME"]."://cheappanel.mohatron.com/";
    $localSite = $_SERVER["REQUEST_SCHEME"]."://cheap.mohatron.com/";

    if($_GET['ln']){
        $_SESSION['lng'] = $_GET['ln'];
    }