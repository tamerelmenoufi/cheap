<?php
    session_start();

    // include("connect_local.php");

    include("/cheapinc/connect.php");
    $con = AppConnect('app');

    // include("/appinc/connect.php");
    include("fn.php");

    $md5 = md5(date("YmdHis"));

    include("dicionary_".(($_SESSION['lng'])?$_SESSION['lng']:'en').".php");

    $localPainel = $_SERVER["REQUEST_SCHEME"]."://cheappanel.mohatron.com/";
    $localSite = $_SERVER["REQUEST_SCHEME"]."://cheap.mohatron.com/";

    if($_GET['ln']){
        $_SESSION['lng'] = $_GET['ln'];
    }