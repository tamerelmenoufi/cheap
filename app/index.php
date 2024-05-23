<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/painel/lib/includes.php");
?><!DOCTYPE html>
<html lang="<?=$_SESSION['lng']?>" <?=(($_SESSION['lng'] == 'ar')?'dir="rtl"':false)?>>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2c93c3"/>
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>TCV</title>
    <?php include("{$_SERVER['DOCUMENT_ROOT']}/app/lib/header.php"); ?>
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div class="Carregando">
    <span>
        <i class="fa-solid fa-spinner"></i>
    </span>
</div>

<div class="ms_corpo"></div>

<?php include("{$_SERVER['DOCUMENT_ROOT']}/app/lib/footer.php"); ?>

<script src="<?= "js/app.js?" . date("YmdHis"); ?>"></script>
<script src="<?= "js/wow.js"; ?>"></script>

<script>
    $(function () {
        AppUsuario = window.localStorage.getItem('AppUsuario');
        $.ajax({
            url: "src/home/index.php",
            type:"POST",
            data:{
                AppUsuario
            },
            success: function (dados) {
                $(".ms_corpo").html(dados);
            }
        });
    })

    //Configurações globais

    //Jconfirm
    jconfirm.defaults = {
        theme: "modern",
        type: "blue",
        typeAnimated: true,
        smoothContent: true,
        draggable: false,
        animation: 'bottom',
        closeAnimation: 'top',
        animateFromElement: false,
        animationBounce: 1.5
    }

</script>
<form></form>
</body>
</html>