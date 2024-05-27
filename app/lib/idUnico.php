<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");

    if($_POST['idUnico']){
        $_SESSION['idUnico'] = $_POST['idUnico'];
    }
    if($_POST['codUsr']){
        $_SESSION['codUsr'] = $_POST['codUsr'];
    }

    if($_POST['idUnico']){
        $n = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `customers` where device = '{$_POST['idUnico']}'"));
        if(!$n){
            mysqli_query($con, "insert into customers set device = '{$_POST['idUnico']}'");
        }
    }

?>